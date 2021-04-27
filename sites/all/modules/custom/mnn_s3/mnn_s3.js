/**
 * @file
 * Automatically uploads the file once the user has selected it.
 */

(function ($) {

  Drupal.behaviors.autoUpload = {
    attach: function (context, settings) {
      // As soon as a file is selected click the upload button to start the upload.
      $('.s3fs-cors-upload-file', context).on("change",function(){
        var btn = $('.cors-form-submit', context);
        btn.click();
      });
    },
  };


})(jQuery);
