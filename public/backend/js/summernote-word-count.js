(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery);
    }
}(function ($) {
    $.extend($.summernote.plugins, {
        wordCount: function (context) {
            var self = this;
            var layoutInfo = context.layoutInfo;
            var $editable = layoutInfo.editable;
            var $statusbar = layoutInfo.statusbar;
            var $editor = layoutInfo.editor;

            self.$wordCountLabel = null;
            self.$hiddenWordCountField = null;

            self.initialize = function () {

                var editorName = $editor.parent().find('textarea').attr('name');
                self.$hiddenWordCountField = $('<input>').attr({
                    type: 'hidden',
                    name: 'word_count_' + editorName,
                    value: 0 // Initialize with 0 words
                });
                $editable.parent().append(self.$hiddenWordCountField);


                // Create and append word count label to the status bar
                var countLabel = document.createElement("span");
                self.$wordCountLabel = $(countLabel);
                self.$wordCountLabel.addClass('wordcount');
                self.$wordCountLabel.css({
                    width: 'auto',
                    display: 'flex',
                    'justify-content': 'end',
                    'margin-right': '10px',
                    'margin-bottom': '10px'
                });
                $statusbar.append(self.$wordCountLabel);
                // Initialize the word count
                self.updateCount('');

                // Listen for any input in the editor and update word count
                $editable.on('keyup', function () {
                    self.updateCount($editable.text());
                });
            };

            self.updateCount = function (text) {
                var length = 0;

                var isThai = /[\u0E00-\u0E7F]/.test(text);


                if (isThai) {
                    var Wordcut = require("wordcut");
                     Wordcut.init();
                    var words = Wordcut.cut(text.trim());

                   let  splitWords =words.split('|').filter(Boolean);

                    splitWords = splitWords.filter(word => word.trim().length > 0);

                    length= splitWords.length
                } else {
                    // For other languages, use regular word counting (split by spaces)
                    length = text.trim().split(/\s+/).filter(function (word) {
                        return word.length > 0;
                    }).length;
                }


                self.$wordCountLabel.text(window.jsLang('data_words') + ": " + window.translatedNumber(length));
                // Update the hidden word count field
                self.$hiddenWordCountField.val(length);

            };
        }
    });

}));
