$(document).foundation();


(function() {

    /***** SETUP *****/

    //Check for modern functionality
    var fileReaderExists = true,
        formDataExists = true;
    if (window.FileReader === undefined) {
        fileReaderExists = false;
        $('#imgPreview1').hide();
        $('#imgPreview2').hide();
        $('#imgPreview3').hide();
    }
    if (window.FormData === undefined) {
        formDataExists = false;
        
    }


    /***** EVENT HANDLERS *****/

    //Provide a preview of the image
    $("#imgUpload1").change(function() {
        if (fileReaderExists) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview1').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $("#imgUpload2").change(function() {
        if (fileReaderExists) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview2').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $("#imgUpload3").change(function() {
        if (fileReaderExists) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview3').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    //Send the form
    $('#sendform').click(function(e) {
        //If client supports HTML5 FormData, use the ajax uploader
        if (formDataExists) {
            e.preventDefault();

            //Show uploading status
            showBanner("Uploading...", false);

            //Disable form temporarily
            $('#sendform').prop("disabled", true);

            //Basic form validation for required fields
            var isError = false;
            $('input, textarea, select').removeClass('required');
            $('input, textarea, select').each(function() {
                if ($(this).prop('required') && $(this).val() == "") {
                    $(this).addClass('required')
                    isError = true;
                }
            })
            if (isError) {
                showBanner('Please fill in the required fields.', true);
                return;
            }

            var payload = new FormData();
            // console.log($('#imgUpload2')[0].files[0]);
            if ($('#imgUpload2')[0].files[0] == null) {
              console.log('is blank')
            } else {
              payload.append('image2', $('#imgUpload2')[0].files[0]);
              payload.append('caption2', $("textarea[name='caption2']").val());
            }

            if ($('#imgUpload3')[0].files[0] == null) {
              console.log('is blank')
            } else {
              payload.append('image3', $('#imgUpload3')[0].files[0]);
              payload.append('caption3', $("textarea[name='caption3']").val());
            }
            payload.append('ajaxEnabled', true);
            payload.append('firstName', $("input[name='firstName']").val());
            payload.append('lastName', $("input[name='lastName']").val());
            payload.append('email', $("input[name='email']").val());
            payload.append('category', $("select[name='category']").val());
            payload.append('caption1', $("textarea[name='caption1']").val());
            payload.append('image1', $('#imgUpload1')[0].files[0]);
            console.log(payload.get('image1'));
            console.log(payload.get('image2'));
            console.log(payload.get('image3'));
            console.log(payload.get('caption1'));
            console.log(payload.get('caption2'));
            console.log(payload.get('caption3'));
            $.ajax({
                url: "image-uploader.php",
                type: "POST",
                data: payload,
                cache: false,
                processData: false,
                contentType: false,
                context: this,
                success: function(response) {
                    console.log(response);
                    if (response.ok === true) {
                        showBanner('Success! We received your submission.', false);
                        // showBanner();
                        $('#imgPreview1').attr('src', 'image-preview-placeholder.png');
                        $('#imgPreview2').attr('src', 'image-preview-placeholder.png');
                        $('#imgPreview3').attr('src', 'image-preview-placeholder.png');
                        $('#caption1').val('');
                        $('#caption2').val('');
                        $('#caption3').val('');
                        $('#imgUpload1').val('');
                        $('#imgUpload2').val('');
                        $('#imgUpload3').val('');
                        payload = "";
                    } 

                    if (response.ok === false) {
                        showBanner('Uh oh, it looks like we couldn\'t process this message. You can manually submit your message to jteoh@lohud.com', true);
                      // showBanner();
                    }
                }
            });
        }
    })


    /***** FUNCTIONS *****/

    //Show message on AJAX return
    function showBanner(message, error) {
        $('#sendform').prop("disabled", false);

        if (error === false) {
            $('#form-banner').css('color', '#28BB28');
        } else if (error === true) {
            $('#form-banner').css('color', '#BB283E');
        }
        $('#form-banner').html(message);
        $('#form-banner').fadeIn().css("display", "inline-block");
    }
})();

lohudmetrics({
  'pagename': 'Image Uploader',
  'author': 'Kai Teoh',
})
