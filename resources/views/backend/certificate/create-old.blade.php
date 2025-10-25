<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div class="form-row">
        <div id="status"></div>
        <br/>
        <div class="clearfix"></div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="">Type</label>
            <select class="form-control" name="type">
                <option value="">Please select type</option>
                    <option value="regular">Regular</option>
                    <option value="test">Test</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for="">Course</label>
            <select class="form-control" name="course_id">
                <option value="">Please select course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                 @endforeach
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Certificate Number </label>
            <input type="text" class="form-control" id="certificate_number" name="certificate_number" value="" placeholder="">
            <span id="error_certificate_number" class="has-error"></span>
        </div>
        <div class="col-md-6">
            <label for="image">Image (File must be jpg, jpeg, png)</label>
            <div class="input-group">
                <input id="image" type="file" name="image" style="display:none">
                <div class="input-group-prepend">
                    <a class="btn btn-secondary text-white" onclick="$('input[id=image]').click();">Browse</a>
                </div>
                <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
                       value="" readonly>
            </div>
            <script type="text/javascript">
                $('input[id=image]').change(function () {
                    $('#SelectedFileName').val($(this).val());
                });
            </script>
            <span id="error_image" class="has-error"></span>
        </div>

        <div class="col-md-12">
            <label for="pdf">PDF (File must be pdf)</label>
            <div class="input-group">
                <input id="pdf" type="file" name="pdf" style="display:none" accept=".pdf">
                <div class="input-group-prepend">
                    <a class="btn btn-secondary text-white" onclick="$('input[id=pdf]').click();">Browse</a>
                </div>
                <input type="text" name="SelectedpdfFileName" class="form-control" id="SelectedpdfFileName" value="" readonly>
            </div>
            <script type="text/javascript">
                $('input[id=pdf]').change(function () {
                    var fileName = $(this).val().split('\\').pop(); // Get the file name
                    $('#SelectedpdfFileName').val(fileName); // Display the file name
                });
            </script>
            <span id="error_pdf" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12 mb-3" style="margin-top: 1%">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {

        $('#create').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                type: {
                    required: true
                },
                course_id: {
                    required: true
                },
                certificate_number: {
                    required: true
                },
                SelectedFileName: {
                    required: true
                }

            },
            // Messages for form validation
            messages: {
                type: {
                    required: 'Select type'
                },
                course_id: {
                    required: 'Enter course id'
                },
                certificate_number: {
                    required: 'Enter certificate number'
                },
                SelectedFileName: {
                    required: 'Please select an image'
                }
            },
            submitHandler: function (form) {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'certificates',
                    type: 'POST',
                    data: myData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('#loader').show();
                        $("#submit").prop('disabled', true); // disable button
                    },
                    success: function (data) {

                        if (data.type === 'success') {
                            reload_table();
                            notify_view(data.type, data.message);
                            $('#loader').hide();
                            $("#submit").prop('disabled', false); // disable button
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('#myModal').modal('hide'); // hide bootstrap modal

                        } else if (data.type === 'error') {
                            notify_view(data.type, data.message);
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $('#loader').hide();
                            $("#submit").prop('disabled', false); // disable button

                        }

                    }
                });

            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>
