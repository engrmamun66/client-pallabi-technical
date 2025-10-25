
<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
novalidate>
    <div class="form-row">
        <div id="status"></div>
        <div class="form-group col-md-12 col-sm-12">
            <label for="">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" value=""
                   placeholder="title" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-12 col-sm-12">
            <label for="">Event Description</label>
            <input type="text" class="form-control" id="description" name="description" value=""
                   placeholder="description" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-12 col-sm-12">
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
        <div class="clearfix"></div>
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success"><span class="fa fa-save fa-fw"></span> Save</button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>


<script>
    $(document).ready(function () {
        $('#loader').hide();
        $('#create').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                name: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Enter Name'
                }
            },
            submitHandler: function (form) {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'events',
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
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            notify_view(data.type, data.message);
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
