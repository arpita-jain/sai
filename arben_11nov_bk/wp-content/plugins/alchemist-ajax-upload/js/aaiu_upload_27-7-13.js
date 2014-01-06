jQuery(document).ready(function ($) {
    var AAIU_Upload = {
        init:function () {
            window.aaiuUploadCount = typeof(window.aaiuUploadCount) == 'undefined' ? 0 : window.aaiuUploadCount;
            this.maxFiles = parseInt(aaiu_upload.number);
            //alert(this);
            //$('#aaiu-upload-imagelist').on('click', 'a.action-delete', this.removeUploads);   
            $('.recent-work-area').on('click', 'a.action-delete', this.removeUploads); 
            this.attach();
            this.hideUploader();
        },
        attach:function () {
            // wordpress plupload if not found
            if (typeof(plupload) === 'undefined') {
                return;
            }

            if (aaiu_upload.upload_enabled !== '1') {
                return
            }

            var uploader = new plupload.Uploader(aaiu_upload.plupload);

            $('#aaiu-uploader').click(function (e) {
                
              
              img_category= $("input:radio[name=img_category]:checked").val();
             // alert(img_category);
                uploader.start();
                // To prevent default behavior of a tag
                e.preventDefault();
            });

            //initilize  wp plupload
            uploader.init();

            uploader.bind('FilesAdded', function (up, files) {
               
                $.each(files, function (i, file) {
                
                    html1= $('#aaiu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                            file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                            '</div>');
                 
                      var result = $.parseJSON(html1.response);   
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );

                up.refresh(); // Reposition Flash/Silverlight
            });

            uploader.bind('FileUploaded', function (up, file, response) {
                var result = $.parseJSON(response.response);
               
                $('#' + file.id).remove();
                if (result.success) {
                    window.aaiuUploadCount += 1;
                    $('#aaiu-upload-imagelist ul').append(result.html);
                       // alert(result.html);
                      radio_val= $('input[name=img_category]:radio:checked').val();
                        if(radio_val=='before'){
                            //alert('==');
                         $('#Before').append(result.html);
                        }
                    if(radio_val=='after'){
                          $('#after').append(result.html);
                    }
                     /*   $("input:radio[name=img_category]").click(function() {
                        var value = $(this).val();
                        alert(value);
                        });*/
                    AAIU_Upload.hideUploader();
                }
            });


        },

        hideUploader:function () {

            if (AAIU_Upload.maxFiles !== 0 && window.aaiuUploadCount >= AAIU_Upload.maxFiles) {
                $('#aaiu-uploader').hide();
            }
        },

        removeUploads:function (e) {
            alert(parseInt(e));
            e.preventDefault();

            if (confirm(aaiu_upload.confirmMsg)) {
             
                var el = $(this),
                    data = {
                        'attach_id':el.data('upload_id'),
                        'nonce':aaiu_upload.remove,
                        'action':'aaiu_delete'
                    };

                $.post(aaiu_upload.ajaxurl, data, function () {
                    el.parent().remove();

                    window.aaiuUploadCount -= 1;
                    if (AAIU_Upload.maxFiles !== 0 && window.aaiuUploadCount < AAIU_Upload.maxFiles) {
                        $('#aaiu-uploader').show();
                    }
                });
            }
        }

    };

    AAIU_Upload.init();
});
$(window).load(function () {
                $('#aaiu-upload-container').removeAttr('style');
  // run code
});