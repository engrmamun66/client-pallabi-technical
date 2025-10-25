<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8"
    class="needs-validation" novalidate>
    <div class="form-row">
        <div id="status"></div>
        <br />
        <div class="clearfix"></div>
        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Menu Name * </label>
            <input type="text" class="form-control" id="title" name="title" value="" placeholder=""
                required>
            <span id="error_title" class="has-error"></span>
        </div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Course Name * </label>
            <input type="text" class="form-control" id="course_name" name="course_name" value="" placeholder=""
                required>
            <span id="error_course_name" class="has-error"></span>
        </div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Price * </label>
            <input type="text" class="form-control" id="price" name="price" value="" placeholder=""
                required>
            <span id="error_price" class="has-error"></span>
        </div>
        <div class="form-group col-md-6 col-sm-12">
            <label for=""> Duration * </label>
            <div class="input-group">
                <input type="text" class="form-control" id="duration" name="duration" value="" placeholder=""
                    required>
                <div class="input-group-append">
                    <select class="form-control" id="duration_unit" name="duration_type" required>
                        <option value="week">Week</option>
                        <option value="month" selected>Month</option>
                        <option value="year">Year</option>
                    </select>
                </div>
            </div>
            <span id="error_duration" class="has-error"></span>
        </div>
        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Description </label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <span id="error_description" class="has-error"></span>
        </div>
        <div class="col-md-12">
            <label for="image">Image (File must be jpg, jpeg, png)</label>
            <div class="input-group">
                <input id="image" type="file" name="image" style="display:none">
                <div class="input-group-prepend">
                    <a class="btn btn-secondary text-white" onclick="$('input[id=image]').click();">Browse</a>
                </div>
                <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName" value=""
                    readonly>
            </div>
            <script type="text/javascript">
                $('input[id=image]').change(function() {
                    $('#SelectedFileName').val($(this).val());
                });
            </script>
            <span id="error_image" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-12 mb-3" style="margin-top: 1%">
            <button type="submit" class="btn btn-success button-submit" data-loading-text="Loading..."><span
                    class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('description');
        }

        $('#create').validate({ // <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                title: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                title: {
                    required: 'Enter course title'
                }
            },
            submitHandler: function(form) {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'courses',
                    type: 'POST',
                    data: myData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loader').show();
                        $("#submit").prop('disabled', true); // disable button
                    },
                    success: function(data) {

                        if (data.type === 'success') {
                            reload_table();
                            notify_view(data.type, data.message);
                            $('#loader').hide();
                            $("#submit").prop('disabled', false); // disable button
                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");
                            $('#myModal').modal('hide'); // hide bootstrap modal

                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function(key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            // $("#status").html(data.message);
                            notify_view(data.type, data.message);
                            $('#loader').hide();
                            $("#submit").prop('disabled', false); // disable button

                        }

                    }
                });

            }
            // <- end 'submitHandler' callback
        }); // <- end '.validate()'

    });
</script>
