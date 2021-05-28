<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet"
    href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="{{asset('js/app.js')}}"></script>
  <title>WRSC Membership Application</title>

@include('membership_application.common_title_style')
    <div class="jumbotron col-md-6 offset-md-3 alert-success">
      <p class="lead ">
        Please complete the details for the family member. Family members must reside as the same address as the primary
        member.
        Please Note:
        <ul>
                  <li>All carers and rescuers must be over the age of 18 years by law </li>
                  <li>Wildlife Rescue South Coast members must be financial and 18 years and over to vote at meetings
          </li>
                  <li>Membership depends the application being accepted by our committee. This happens at the
            monthly committee meeting. If your application is received after these meetings it may not be accepted
            until the following month.</li>
        </ul>
      </p>
      <hr class="my-4">
      <p>If you encounter any difficulties please email <a
          href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a></p>
    </div>
    @if($errors->any())
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>

      @foreach($errors->all() as $error)
      {{ $error }}<br />
      @endforeach
    </div>
    @endif

    <form class="col-md-6 offset-md-3" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="family_member" value="1" />
      <input type="hidden" name="primary_member_id" value="{{$primary_member->id}}" />
      <input type="hidden" name ="form_token" value="{{$token}}"/>

@include('membership_application.common_contact')

      <div class="form-group row">
        <label for="address_residential" class="col-4 col-form-label">Primary Residential Address. </label>
        <div class="col-8">
          {!!$primary_member->formattedResidentialAddress()!!}
        </div>
      </div>

      <div class="form-group row">
        <label for="address_residential" class="col-4 col-form-label">Postal Address. </label>
        <div class="col-8">
          {!!$primary_member->formattedPostalAddress()!!}
        </div>
      </div>
@include('membership_application.common_phone_input')
      <div class="form-group row">
        <label for="email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
          <input id="email" name="email" placeholder="your@email.at" type="email" class="form-control"
            aria-describedby="emailHelpBlock" value="{{ old('email')}}">
          <span id="emailHelpBlock" class="form-text text-muted">Enter Your email Address</span>
        </div>
      </div>
      <div>
      <div class="form-group row">
        <label class="col-4">Are you over 18?</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="over_18" id="over_18_0" type="radio" class="form-check-input" value="yes"
              aria-describedby="over_18HelpBlock" checked="checked"  required="required">
            <label for="over_18_0" class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input name="over_18" id="over_18_1" type="radio" class="form-check-input" value="no"
              aria-describedby="over_18HelpBlock" required="required">
            <label for="over_18_1" class="form-check-label">No</label>
          </div>
          <span id="over_18HelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
        </div>
      </div>

@include('membership_application.common_text_input_areas')

      <div class="form-group row">
        <div class="offset-4 col-8">
          <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</body>

<script>
  (function() {
    document.getElementById('previous_conviction_0').addEventListener('change',
      function() {
        page_modal('Warning', "We cannot accept your application if you have you been charged or convicted of an offence relating to wildlife or domestic animals");
      })
  })();


(function() {
  var input = $('<input id="dob" name="dob" max=2050 min=2002 required="required" />');
            
  var label = $('<label id="dob_label" for="over_18_1" class="form-check-label">Please Enter your year of birth</label>')
  document.getElementById('over_18_1').addEventListener('change',function(e){
    var input_element = input[0];
    e.target.parentNode.parentNode.insertBefore(input_element, e.nextSibling);
    input_element.parentNode.insertBefore(label[0], e.nextSibling);
  })
  document.getElementById('over_18_0').addEventListener('change',function(e){
    $('#dob').remove()
    $('#dob_label').remove();
  })
})();
  function page_modal(title, message) {

    var modal = document.getElementById('modal');
    var modal_template_text = document.getElementById('modal_template').innerHTML;
    var new_text = modal_template_text.replace('[[title]]', title).replace('[[text]]',message);
    modal.innerHTML = new_text;
    $('#modal').modal('show')

  }
</script>

<!-- templates -->

<div id="modal" class="modal" tabindex="-1">

</div>

<script id="modal_template" type="text/template">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <div class="alert alert-warning"> <h5 class="modal-title">[[title]]</h5></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>[[text]]</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

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

<script>
  var new_file_input = document.getElementById("multi-certs").outerHTML;
    $('.add_more').click(function(e){
        e.preventDefault();
        $(this).before(new_file_input);
    });
</script>

</html>