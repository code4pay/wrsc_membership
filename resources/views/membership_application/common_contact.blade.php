
      <div class="form-group row">
        <label for="first_name" class="col-4 col-form-label">First Name</label>
        <div class="col-8">
          <input id="first_name" name="first_name" placeholder="First Name" type="text" class="form-control"
            aria-describedby="first_nameHelpBlock" required="required" value="{{ old('first_name')}}">
          <span id="first_nameHelpBlock" class="form-text text-muted">Enter first name</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="last_name" class="col-4 col-form-label">Last Name</label>
        <div class="col-8">
          <input id="last_name" name="last_name" placeholder="Last Name" type="text" class="form-control"
            aria-describedby="last_nameHelpBlock" required="required" value="{{ old('last_name')}}">
          <span id="last_nameHelpBlock" class="form-text text-muted">Enter last name</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="title" class="col-4 col-form-label">Title</label>
        <div class="col-2">
          <select id="title" name="title" class="form-control" aria-describedby="titleHelpBlock" required="required"
            value="{{ old('title')}}">
            <option value="ms">Ms</option>
            <option value="mr">Mr</option>
            <option value="mrs">Mrs</option>
            <option value="dr">Dr</option>
          </select>
          <span id="titleHelpBlock" class="form-text text-muted">Enter your title</span>
        </div>
      </div>