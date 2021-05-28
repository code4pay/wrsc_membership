<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/packages/backpack/base/css/bundle.css?v=4.0.61@1977e0cc52fa7cf9547eaeadf03f5cd88402b574">-->
    <!-- <link rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/packages/source-sans-pro/source-sans-pro.css?v=4.0.61@1977e0cc52fa7cf9547eaeadf03f5cd88402b574">-->
    <!-- <link rel="stylesheet" type="text/css" href="http://127.0.0.1:8000/packages/line-awesome/css/line-awesome.min.css?v=4.0.61@1977e0cc52fa7cf9547eaeadf03f5cd88402b574">-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <script src="{{asset('js/app.js')}}"></script>
    <title>Upload Files</title>
    <style>
        .hide {
            display: none;
        }

        .image .btn-group {
            margin-top: 10px;
        }

        img {
            max-width: 100%;
            /* This rule is very important, please do not ignore this! */
        }

        .img-container,
        .img-preview {
            width: 100%;
            text-align: center;
        }

        .img-preview {
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .preview-lg {
            width: 263px;
            height: 148px;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid-md">
        <div class="jumbotron col-md-6 offset-md-3 ">
            <h1 class="display-4">Wildlife Rescue South Coast, Application Form</h1>
            <p class="lead ">
                If you would like your photo on your membership ID card, please upload a portrait photo here (photos are required for members who:
            <ul>
                       <li> participate in any fund raising activities,</li>
                       <li>are responsible for incurring expenses on behalf of Wildlife Rescue South Coast Inc. </li>
                       <li>are authorised and trained to euthanase injured wildlife by firearm.</li>
            </ul>
            </p>
            <hr class="my-4">
            <p>If you encounter any difficulties please email <a href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a></p>
        </div>
            <div class="container mt-5">
                <form action="{{route('id_upload')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    @csrf
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div id="photo" data-preview="#image" data-aspectRatio="1" data-crop="1" class="form-group col-sm-12 cropperImage " data-init-function="bpFieldInitCropperImageElement" data-field-name="image">
                        <div>
                            <label>Profile Image</label>
                        </div>
                        <!-- Wrap the image or canvas element with a block element (container) -->
                        <div class="row">
                            <div class="col-sm-6" data-handle="previewArea" style="margin-bottom: 20px;">
                                <img data-handle="mainImage" src="">
                            </div>
                            <div class="col-sm-3" data-handle="previewArea">
                                <div class="docs-preview clearfix">
                                    <div id="image" class="img-preview preview-lg">
                                        <img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn btn-light btn-sm btn-file">
                                Choose file <input type="file" accept="image/*" data-handle="uploadImage" class="hide">
                                <input type="hidden" data-handle="hiddenImage" name="image">
                            </div>
                            <button class="btn btn-light btn-sm" data-handle="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>
                            <button class="btn btn-light btn-sm" data-handle="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>
                            <button class="btn btn-light btn-sm" data-handle="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>
                            <button class="btn btn-light btn-sm" data-handle="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>
                            <button class="btn btn-light btn-sm" data-handle="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>
                            <button class="btn btn-light btn-sm" data-handle="remove" type="button"><i class="fa fa-trash"></i></button>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            Attachment(s)
                            (Attach multiple files.)
                        </label>
                        <div class="col-sm-9">
                            <span class="btn btn-default btn-file">
                                <input id="input-2" name="input2[]" type="file"  multiple data-show-upload="true" data-show-caption="true">
                            </span>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</body>


<script>
$("#input-2").fileinput();
</script>

<script>
function bpFieldInitCropperImageElement(element) {
    // Find DOM elements under this form-group element
    var $mainImage = element.find('[data-handle=mainImage]');
    var $uploadImage = element.find("[data-handle=uploadImage]");
    var $hiddenImage = element.find("[data-handle=hiddenImage]");
    var $rotateLeft = element.find("[data-handle=rotateLeft]");
    var $rotateRight = element.find("[data-handle=rotateRight]");
    var $zoomIn = element.find("[data-handle=zoomIn]");
    var $zoomOut = element.find("[data-handle=zoomOut]");
    var $reset = element.find("[data-handle=reset]");
    var $remove = element.find("[data-handle=remove]");
    var $previews = element.find("[data-handle=previewArea]");
    // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
    var options = {
    viewMode: 2,
        checkOrientation: false,
        autoCropArea: 1,
        responsive: true,
        preview: element.attr('data-preview'),
        aspectRatio: element.attr('data-aspectRatio')
    };
    var crop = element.attr('data-crop');

    // Hide 'Remove' button if there is no image saved
    if (!$mainImage.attr('src')) {
        $previews.hide();
        $remove.hide();
    }
    // Initialise hidden form input in case we submit with no change
    $hiddenImage.val($mainImage.attr('src'));


    // Only initialize cropper plugin if crop is set to true
    if (crop) {

        $remove.click(function() {
            $mainImage.cropper("destroy");
            $mainImage.attr('src', '');
            $hiddenImage.val('');
            $rotateLeft.hide();
            $rotateRight.hide();
            $zoomIn.hide();
            $zoomOut.hide();
            $reset.hide();
            $remove.hide();
            $previews.hide();
        });
    } else {

        $remove.click(function() {
            $mainImage.attr('src', '');
            $hiddenImage.val('');
            $remove.hide();
            $previews.hide();
        });
    }

    $uploadImage.change(function() {
        var fileReader = new FileReader(),
            files = this.files,
file;

if (!files.length) {
    return;
}
file = files[0];

const maxImageSize = 104857600;
if (maxImageSize > 0 && file.size > maxImageSize) {

    alert(`Please pick an image smaller than ${maxImageSize} bytes.`);
} else if (/^image\/\w+$/.test(file.type)) {

    fileReader.readAsDataURL(file);
    fileReader.onload = function() {

        $uploadImage.val("");
        $previews.show();
        if (crop) {
            $mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
            // Override form submit to copy canvas to hidden input before submitting
            $('form').submit(function() {
                var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL(file.type);
                $hiddenImage.val(imageURL);
                return true; // return false to cancel form action
            });
            $rotateLeft.click(function() {
                $mainImage.cropper("rotate", 90);
            });
            $rotateRight.click(function() {
                $mainImage.cropper("rotate", -90);
            });
            $zoomIn.click(function() {
                $mainImage.cropper("zoom", 0.1);
            });
            $zoomOut.click(function() {
                $mainImage.cropper("zoom", -0.1);
            });
            $reset.click(function() {
                $mainImage.cropper("reset");
            });
            $rotateLeft.show();
            $rotateRight.show();
            $zoomIn.show();
            $zoomOut.show();
            $reset.show();
            $remove.show();

        } else {
            $mainImage.attr('src', this.result);
            $hiddenImage.val(this.result);
            $remove.show();
        }
    };
} else {
    new Noty({
    type: "error",
        text: "<strong>Please choose an image file</strong><br>The file you've chosen does not look like an image."
}).show();
}
    });
}
bpFieldInitCropperImageElement($('#photo'));
</script>

</html>
