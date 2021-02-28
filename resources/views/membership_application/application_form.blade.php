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
    <div class="jumbotron col-md-6 offset-md-3 alert-success " >
      <h1 class="display-4"><image  src="/images/wrsc_small.png">Wildlife Rescue South Coast, Application Form</h1>
      <p class="lead ">
        Thank you for wanting to become a member.
        WRSC is licenced by NPWS and we abide by our licence conditions</p>
      <div class="alert alert-primary">Please note, before you can rescue and care, you will need specific training
        and the majority of caring of native animals occurs in members homes
      </div>
      <p>The cost of membership is a ${{Config::get('app.primary_member_fee')}} annual fee for the Primary member, plus a once off joining fee of ${{Config::get('app.application_fee')}} which
        includes cost of the Introduction course. Family members can join for a  ${{Config::Get('app.family_member_fee')}} annual fee </p>
<p> We do offer a Junior membership to those under the age of 18 </p>
      <p> Each person applying must complete a separate application form.</p>
      <p> If someone in the household is a member of WIRES, please contact the membership officer <a
          href="mailto:membership@wildlife-rescue.org.au">membership@wildlife-rescue.org.au</a>
        <p>
          <div class="alert alert-warning">Native animals are not pets, our aim is that native animals are to be
            rehabilitated when we can, and returned to the wild</div>
          Please Note:
          <ul>
                    <li>All carers and rescuers must be over the age of 18 years by law </li>
                    <li>Wildlife Rescue South Coast members must be financial and 18 years and over to vote at meetings
            </li>
                    <li>Membership depends on your application being accepted by our committee. This happens at the
              monthly committee meeting. If your application is received after these meetings it may not be accepted
              until the following month.</li>
                    <li>Our membership year runs from July to June. </li>
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
      <input type="hidden" name ="form_token" value="{{$token}}"/>
      
@include('membership_application.common_contact')

      <div class="form-group row">
        <label for="address_residential" class="required col-4 col-form-label">Primary Residential Address. <strong> Please note
            you cannot care for wildlife outside our licenced area, but may assist within our licenced area. <a
              href="images/wrsc_map.pdf"> Click Here</a> for licenced area</strong></label>
        <div class="col-8">
          <input id="address_residential" name="address_residential" placeholder="Enter Your Residential Address"
            type="text" class="form-control" aria-describedby="address_residential HelpBlock">
          <span id="address_residential HelpBlock" class="form-text text-muted">Enter your residential address</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="city_residential" class="required col-4 col-form-label">Residential City </label>
        <div class="col-8">
          <input id="city_residential" name="city_residential" placeholder="City" type="text" class="form-control"
            aria-describedby="city_residentialHelpBlock">
          <span id="city_residentialHelpBlock" class="form-text text-muted">Enter your residential city </span>
        </div>
      </div>
      <div class="form-group row">
        <label for="post_code_residential" class="required col-4 col-form-label">Postcode Residental </label>
        <div class="col-8">
          <input id="post_code_residential" name="post_code_residential" placeholder="Post Code" type="number"
            class="form-control" min=2000 max=9000  aria-describedby="post_code_residentialHelpBlock" >
          <span id="post_code_residentialHelpBlock" class="form-text text-muted">Enter your residential postcode </span>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-4">Postal address is the same as Residential Address.</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="addresses_same" id="addresses_same_0" type="checkbox"
              aria-describedby="addresses_sameHelpBlock" class="form-check-input" value="yes">
            <label for="addresses_same_0" class="form-check-label"></label>
          </div>
          <span id="addresses_sameHelpBlock" class="form-text text-muted">Tick if your postal and residential address
            are the same.</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="address" class="required col-4 col-form-label">Address (Postal)</label>
        <div class="col-8">
          <input id="address" name="address" placeholder="Your Address" type="text" class="form-control"
            aria-describedby="addressHelpBlock" required="required">
          <span id="addressHelpBlock" class="form-text text-muted">Enter your postal address</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="city" class="required col-4 col-form-label">City (Postal)</label>
        <div class="col-8">
          <input id="city" name="city" placeholder="City" type="text" class="form-control"
            aria-describedby="cityHelpBlock" required="required">
          <span id="cityHelpBlock" class="form-text text-muted">Enter Your city</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="post_code" class="required col-4 col-form-label">Post Code (Postal)</label>
        <div class="col-8">
          <input id="post_code" name="post_code" placeholder="Post Code" min=2000 max=9000 type="number" class="form-control"
            required="required">
        </div>
      </div>

@include('membership_application.common_phone_input')
      <div class="form-group row">
        <label for="email" class="required col-4 col-form-label">Email</label>
        <div class="col-8">
          <input id="email" name="email" placeholder="your@email.at" type="email" class="form-control"
            aria-describedby="emailHelpBlock" required="required">
          <span id="emailHelpBlock" class="form-text text-muted">Enter Your email Address</span>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-4 required ">Please confirm you are over the age of 18?</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="over_18" id="over_18_0" type="checkbox" aria-describedby="over_18HelpBlock"
              class="form-check-input" value="yes" required="required">
            <label for="over_18_0" class="form-check-label"></label>
          </div>
          <span id="over_18HelpBlock" class="form-text text-muted">You can not be a primary member if you are under
            the age of 18.</span>
        </div>
      </div>

      <div class="form-group row">
        <label class="required col-4">Is any member of your household a member of Wires?</label>
        <div class="col-8">
          <div class="form-check form-check-inline">
            <input name="member_wires" id="member_wires_0" type="radio" class="form-check-input" value="yes"
              aria-describedby="member_wireshelpblock" required="required">
            <label for="member_wires_0" class="form-check-label">yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input name="member_wires" id="member_wires_1" type="radio" class="form-check-input" value="no"
              aria-describedby="member_wireshelpblock" required="required">
            <label for="member_wires_1" class="form-check-label">no</label>
          </div>
          <span id="member_wireshelpblock" class="form-text text-muted">please tick which applies to you.</span>
        </div>
      </div>

@include('membership_application.common_text_input_areas')

      <div class="form-group row">
        <label for="capatcha" class="required col-4 col-form-label">Prove you are human</label>
        <div class="col-4">
          <img src="/images/capatcha.jpeg" />
          <input id="capatcha" name="capatcha" placeholder="" size=10 type="text" class="form-control"
            aria-describedby="capatchaHelpBlock" required="required">
          <span id="capatchaHelpBlock" class="form-text text-muted">Enter the letters from the image above</span>
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
    var checkbox = document.getElementById('addresses_same_0').addEventListener('change',
      function() {
        if (this.checked) {
          var address_fields = ['address', 'city', 'post_code']
          address_fields.forEach(function(field) {
            document.getElementById('residential_' + field).value = document.getElementById(field).value;
          })
        }
      });
  })();
  
  
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
  (function() {
    var checkbox = document.getElementById('addresses_same_0').addEventListener('change',
      function() {
        if (this.checked) {
          var address_fields = ['address', 'city', 'post_code']
          address_fields.forEach(function(field) {
            document.getElementById(field).value = document.getElementById(field + '_residential').value;
          })
        }
      });
  })();
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