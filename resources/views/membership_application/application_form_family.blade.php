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
        Please complete the details for the family member. Family members must reside as the same address as the primary member.
          Please Note:
          <ul>
                    <li>All carers and rescuers must be over the age of 18 years by law </li>
                    <li>Wildlife Rescue South Coast members must be financial and 18 years and over to vote at meetings </li>
                    <li>Membership depends the  application being accepted by our committee. This happens at the
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
            {{ $error }}<br/>
        @endforeach
    </div>
@endif

    <form class="col-md-6 offset-md-3" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name ="family_member" value="1"/>
      <input type="hidden" name ="primary_member_id" value="{{$primary_member->id}}"/>
      <div class="form-group row">
        <label for="first_name" class="col-4 col-form-label">First Name</label>
        <div class="col-8">
          <input id="first_name" name="first_name" placeholder="First Name" type="text" class="form-control"
            aria-describedby="first_nameHelpBlock" required="required">
          <span id="first_nameHelpBlock" class="form-text text-muted">Enter first name</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="last_name" class="col-4 col-form-label">Last Name</label>
        <div class="col-8">
          <input id="last_name" name="last_name" placeholder="Last Name" type="text" class="form-control"
            aria-describedby="last_nameHelpBlock" required="required">
          <span id="last_nameHelpBlock" class="form-text text-muted">Enter last name</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="title" class="col-4 col-form-label">Title</label>
        <div class="col-2">
          <select id="title" name="title" class="form-control" aria-describedby="titleHelpBlock" required="required">
            <option value="ms">Ms</option>
            <option value="mr">Mr</option>
            <option value="mrs">Mrs</option>
            <option value="dr">Dr</option>
          </select>
          <span id="titleHelpBlock" class="form-text text-muted">Enter your title</span>
        </div>
      </div>
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
      <div class="form-group row">
        <label for="mobile" class="col-4 col-form-label">Mobile phone</label>
        <div class="col-8">
          <input id="mobile" name="mobile" placeholder="Mobile Number" type="tel" class="form-control"
            aria-describedby="mobileHelpBlock" required="required" maxlength=10 minlength=10">
          <span id="mobileHelpBlock" class="form-text text-muted">Enter your mobile phone number</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="home_phone" class="col-4 col-form-label">Land line</label>
        <div class="col-8">
          <input id="home_phone" name="home_phone" placeholder="Home Number" type="tel" class="form-control"
            aria-describedby="home_phoneHelpBlock">
          <span id="home_phoneHelpBlock" class="form-text text-muted">Enter your home phone number</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-4 col-form-label">Email</label>
        <div class="col-8">
          <input id="email" name="email" placeholder="your@email.at" type="email" class="form-control"
            aria-describedby="emailHelpBlock" required="required">
          <span id="emailHelpBlock" class="form-text text-muted">Enter Your email Address</span>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-4">Are you over the age of 18?</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="over_18" id="over_18_0" type="checkbox" aria-describedby="over_18HelpBlock"
              class="form-check-input" value="yes" required="required">
            <label for="over_18_0" class="form-check-label"></label>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-4">Are you now or have you been a member of another wildlife group?</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="member_of_other_group" id="member_of_other_group_0" type="checkbox"
              aria-describedby="member_of_other_groupHelpBlock" class="form-check-input" value="yes ">
            <label for="member_of_other_group_0" class="form-check-label"></label>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="textarea" class="col-4 col-form-label">If you answered YES above – please provide name of group and
          approx year left that group </label>
        <div class="col-8">
          <textarea id="textarea" name="details_of_previous_group" cols="40" rows="5" class="form-control"
            aria-describedby="textareaHelpBlock"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="textarea1" class="col-4 col-form-label">Have you cared for native wildlife in the past 12 months? If
          YES – please give details:</label>
        <div class="col-8">
          <textarea id="textarea1" name="cared_for_wildlife" cols="40" rows="5" class="form-control"
            aria-describedby="textarea1HelpBlock"></textarea>
          <span id="textarea1HelpBlock" class="form-text text-muted"> Provide details of where and which animals</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="textarea1" class="col-4 col-form-label">Is there any species you are particularly interested in?
          if YES – please List here:</label>
        <div class="col-8">
          <textarea id="textarea1" name="interested_in_species" cols="40" rows="5" class="form-control"
            aria-describedby="textarea1HelpBlock"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-4">Have you been charged or convicted of an offence relating to wildlife or domestic animals?
        </label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="previous_conviction" id="previous_conviction_0" type="radio" class="form-check-input"
              value="yes" aria-describedby="previous_convictionHelpBlock" required="required">
            <label for="previous_conviction_0" class="form-check-label">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input name="previous_conviction" id="previous_conviction_1" type="radio" class="form-check-input"
              value="no" aria-describedby="previous_convictionHelpBlock" required="required">
            <label for="previous_conviction_1" class="form-check-label">No</label>
          </div>
          <span id="previous_convictionHelpBlock" class="form-text text-muted">Please tick which applies to you.</span>
        </div>
      </div>


      <div class="form-group row ">
        <label class="col-4">Upload Profile Photo</label>
        <div class="col-8">
          <div id="photo" data-preview="#image" data-aspectRatio="1" data-crop="1" class="col-sm-12 cropperImage "
            data-init-function="bpFieldInitCropperImageElement" data-field-name="image">
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
                    <img src=""
                      style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                  </div>
                </div>
              </div>
            </div>

            <div class="btn-group">
              <div class="btn btn-light btn-sm btn-file">
                Choose file <input type="file" accept="image/*" data-handle="uploadImage" class="hide">
                <input type="hidden" data-handle="hiddenImage" name="image">
              </div>
              <button class="btn btn-light btn-sm" data-handle="rotateLeft" type="button" style="display: none;"><i
                  class="fa fa-rotate-left"></i></button>
              <button class="btn btn-light btn-sm" data-handle="rotateRight" type="button" style="display: none;"><i
                  class="fa fa-rotate-right"></i></button>
              <button class="btn btn-light btn-sm" data-handle="zoomIn" type="button" style="display: none;"><i
                  class="fa fa-search-plus"></i></button>
              <button class="btn btn-light btn-sm" data-handle="zoomOut" type="button" style="display: none;"><i
                  class="fa fa-search-minus"></i></button>
              <button class="btn btn-light btn-sm" data-handle="reset" type="button" style="display: none;"><i
                  class="fa fa-times"></i></button>
              <button class="btn btn-light btn-sm" data-handle="remove" type="button"><i
                  class="fa fa-trash"></i></button>
            </div>
          </div>
          <div class="alert alert-primary" role="alert">
            If you would like your photo on your membership ID card, please upload a portrait photo here (photos are
            required for members who:)
            <ul>
              <li> participate in any fund raising activities,</li>
              <li> are responsible for incurring expenses on behalf of Wildlife Rescue South Coast Inc. </li>
              <li>are authorised and trained to euthanase injured wildlife by firearm.</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-4">Upload Relevant Training Certificates</label>
        <div class="col-8">
          <div class="form-check form-check-inline" id="multi-certs">
            <input name="documents[]" id="certificate_upload_0" type="file" class="" 
              aria-describedby="certificate_uploadhelpblock multiple" >

          </div>

           <button class="add_more btn btn-primary">Add More</button><br/>
          <span id="certificate_uploadhelpblock" class="form-text text-muted">If you have any wildlife training certificate less than three years old, please upload them here</span>
        </div>
      </div>

  <div class="jumbotron col-md-12  ">
    <h1 class="display-4">Terms and conditions</h1>
    <p class="lead ">
      Upon joining,
      <ol>
        <li>1.      I agree to be bound by the conditions of : </li>
        <ol type="a">
          <li>a: Licence number MWL000100253 issued to Wildlife Rescue South Inc by NPWS. </li>
          <li>b: Constitution, rules and guidelines of Wildlife Rescue South Coast Inc. need to make this
            available somehow </li>
          <li>c: Policies and Procedures of Wildlife Rescue South Coast Inc </li>
        </ol>
        <li>2.      I agree to be guided by the WRSC Coordinators and WRSC Committee in every facet of the
          wildlife’s care and rehabilitation and will allow the relevant coordinators or Committee members to
          inspect my premises at a time of mutual agreement. </li>
        <li>3.      I agree to return any property loaned to me by WRSC when requested by the Committee. </li>
        <li>4.      I agree that all my labour is voluntary and that all activities are carried out at my own risk
          and with no right of recourse against any member of WRSC. </li>
        <li>5.      I declare that I am not a prohibited person under the Commission for Children and Young People
          Act 2007. </li>
        <li>6.      I declare that I have not been convicted on charges relating to wildlife / domestic animals.
        </li>
      </ol>
      <div class="form-group row">
        <label class="col-4">I AGREE TO THE CONDITIONS OF MEMBERSHIP</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="agree_to_conditions" id="agree_to_conditions_0" type="checkbox"
              aria-describedby="agree_to_conditionsHelpBlock" required="required" class="form-check-input" value="yes">
            <label for="agree_to_conditions_0" class="form-check-label">I agree</label>
          </div>
          <span id="agree_to_conditionsHelpBlock" class="form-text text-muted">By ticking this you signify that
            you agree to be bound by the conditions of membership of Wildlife Rescue South Coast.</span>
        </div>
      </div>
  </div>
  <div class="form-group row">
        <label class="col-4">Do you want to add another family member</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="add_family_members" id="add_family_members_0" type="radio" class="form-check-input" value="yes"
              aria-describedby="member_wireshelpblock" required="required">
            <label for="add_family_members_0" class="form-check-label">yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input name="add_family_members" id="add_family_members_1" type="radio" class="form-check-input" value="no"
              aria-describedby="member_wireshelpblock" required="required">
            <label for="add_family_members_1" class="form-check-label">no</label>
          </div>
          <span id="member_wireshelpblock" class="form-text text-muted">Please choose an option</span>
        </div>
      </div>
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
        page_modal('Warning', "We cannot accept your application if you have you been charged or convicted of an offence relating to wildlife or domestic animals?");
      })
  })();


  (function() {
    document.getElementById('member_wires_0').addEventListener('change',
      function() {
        page_modal('Please Note', "WIRES and WRSC policies do not allow members (who are authorised carers) in the same household to belong to the two different groups. We ask that you consider which group the family would like to be members of");
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