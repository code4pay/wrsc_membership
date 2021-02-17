
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
            aria-describedby="textareaHelpBlock" value="{{ old('details_of_previous_group')}}"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label for="textarea1" class="col-4 col-form-label">Have you cared for native wildlife in the past 12 months? If
          YES – please give details:</label>
        <div class="col-8">
          <textarea id="textarea1" name="cared_for_wildlife" cols="40" rows="5" class="form-control"
            aria-describedby="textarea1HelpBlock" value="{{ old('cared_for_wildlife')}}"></textarea>
          <span id="textarea1HelpBlock" class="form-text text-muted"> Provide details of where and which animals</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="textarea1" class="col-4 col-form-label">Is there any species you are particularly interested in?
          if YES – please List here:</label>
        <div class="col-8">
          <textarea id="textarea1" name="interested_in_species" cols="40" rows="5" class="form-control"
            aria-describedby="textarea1HelpBlock" value="{{ old('interested_in_species')}}"></textarea>
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
              aria-describedby="certificate_uploadhelpblock multiple">

          </div>

          <button class="add_more btn btn-primary">Add More</button><br />
          <span id="certificate_uploadhelpblock" class="form-text text-muted">If you have any wildlife training
            certificate less than three years old, please upload them here</span>
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
                  aria-describedby="agree_to_conditionsHelpBlock" required="required" class="form-check-input"
                  value="yes">
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