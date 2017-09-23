var ecn = ecn || {};

(function($) {
    $.fn.insertAtCaret = function(text) {
        return this.each(function() {
            if (document.selection && this.tagName == 'TEXTAREA') {
                //IE textarea support
                this.focus();
                sel = document.selection.createRange();
                sel.text = text;
                this.focus();
            } else if (this.selectionStart || this.selectionStart == '0') {
                //MOZILLA/NETSCAPE support
                startPos = this.selectionStart;
                endPos = this.selectionEnd;
                scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + text + this.value.substring(endPos, this.value.length);
                this.focus();
                this.selectionStart = startPos + text.length;
                this.selectionEnd = startPos + text.length;
                this.scrollTop = scrollTop;
            } else {
                // IE input[type=text] and other browsers
                this.value += text;
                this.focus();
                this.value = this.value;    // forces cursor to end
            }
        });
    };

    ecn.AdminView = Backbone.View.extend({
        el: '#ecn-admin',

        initialize: function() {
            this.$('.result').hide();
            this.$('.loading').hide();
            var self = this;
            $(document).ajaxStart(function() {
                self.$('#fetch_events').attr('disabled', 'disabled').addClass('disabled');
                self.$('.spinner').addClass('is-active');
            });
            $(document).ajaxStop(function() {
                self.$('#fetch_events').removeAttr('disabled').removeClass('disabled');
                self.$('.spinner').removeClass('is-active');
            });
            this.changeDesign();
        },

        events: {
            'click #fetch_events': 'fetchEvents',
            'click #insert_placeholder': 'insertPlaceholder',
            'change select[name="event_calendar"]': 'pluginChanged',
            'click #select_html_results': 'selectHTMLResults',
            'click .nav-tab': 'selectNavTab',
            'change input[name="design"]': 'changeDesign'
        },

        changeDesign: function() {
            if ($('input[name="design"]:checked').val() == 'custom') {
                this.$('.format_editor').show();
            } else {
                this.$('.format_editor').hide();
            }
        },

        selectHTMLResults: function() {
            this.$('#output_html').focus();
            this.$('#output_html').select();
        },

        clearResults: function() {
            this.$('.result').hide();
            this.$('#output_html').val('');
            this.$('#output').html('');
        },

        pluginChanged: function(event) {
            this.clearResults();
            this.fetchAllowedTags(event);
            this.fetchOtherPluginOptions(event);
        },

        fetchOtherPluginOptions: function(event) {
            var self = this;
            self.$('#additional_filters').html('');
            $.get(ajaxurl, {
                    action: 'fetch_other_plugin_options',
                    nonce: self.$('#wp_ecn_admin_nonce').val(),
                    event_calendar: $(event.currentTarget).val()
                }, function(data) {
                    self.$('#additional_filters').html(data);
                }
            );
        },

        fetchAllowedTags: function(event) {
            var self = this;
            self.$('#placeholder').empty();

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'fetch_allowed_tags',
                    nonce: self.$('#wp_ecn_admin_nonce').val(),
                    event_calendar: $(event.currentTarget).val()
                },
                success: function(result) {
                    _.each(result.result, function(text, value) {
                        $('<option />', {
                            val: value,
                            text: text
                        }).appendTo(self.$('#placeholder'));
                    });
                },
                error: function(v, msg) {
                    alert(msg);
                }
            })
        },

        insertPlaceholder: function(event) {
            event.preventDefault();
            var placeholder = this.$('#placeholder').val();
            if ($('#wp-format-wrap').hasClass('html-active'))
                this.$('textarea[name="format"]').insertAtCaret( '{' + placeholder + '}' );
            else
                tinymce.activeEditor.execCommand('mceInsertContent', false, '{' + placeholder + '}')
        },

        selectTab: function(tab) {
            tab = tab.replace('_tab', '');
            this.$('.nav-tab').removeClass('nav-tab-active');
            this.$('#' + tab + '_tab').addClass('nav-tab-active');
            this.$('.tab_container').hide();
            this.$('#' + tab).show();
        },

        hideResults: function() {
            this.$('.result').hide();
        },
        
        selectNavTab: function(event) {
            this.selectTab($(event.currentTarget).attr('id'));
        },

        fetchEvents: function(event) {
            var self = this;
            event.preventDefault();

            // Force updating the textareas
            tinyMCE.triggerSave();

            self.hideResults();
            self.selectTab('results_tab');
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'fetch_events',
                    nonce: self.$('#wp_ecn_admin_nonce').val(),
                    data: $('#ecn-admin form').serialize()
                },
                success: function(result) {
                    self.$('.result').show();
                    self.$('#output_html').val(result.result);
                    self.$('#output').html(result.result);
                },
                error: function(v, msg) {
                    alert(msg);
                }
            });
        }
    });

    $(document).ready(function() {
        ecn.adminView = new ecn.AdminView();
    });
})(jQuery);