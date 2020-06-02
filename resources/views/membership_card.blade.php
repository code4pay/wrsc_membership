<!DOCTYPE html>
<html>

<head>
  <title></title>
  <style type="text/css">
    body {
      font-size: 8px;
      font-family: verdana;
    }

    .column {
      float: left;
      width: 80mm;
      height: 51mm;
      border: 1px solid;
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    h1,
    h2,
    h3,
    h4 {
      text-align: center;
    }
  </style>

</head>

<body>
  @foreach ($users as $user )
  <div class="row" style="margin-bottom: 10mm;">
    <div class="column">
      <h2 style="margin-bottom:5px;">Wildlife Rescue South Coast Inc.</h2>
      <div style="display: inline-block; height: 23mm; overflow:hidden;">
        <div style="padding-left: 2mm;float: left; width: 18mm;">
          <img style="width:43px; height:43px" src="images/wrsc_small.png">
        </div>
        <div style="font-size: 7px; width: 37mm; float: left; ">
          <address>
            NPWS Licence No: MWL000100253<br />
            CFN: 16681<br />
            ABN: 49 616 307 526
          </address>
          <h2 style="margin:0;">VOLUNTEER</h2>
          <div style="font-size:10px">
            Name: <strong>{{ $user->fullName }}</strong> <br />
            Number: <strong>{{ $user->member_number }}</strong>
          </div>
        </div>
        <div style="font-size: 7px; width: 20mm; float:right">
          @if($user->image)
          <img style="height:20mm; width:20mm  padding-right: 1mm;" src="http://127.0.0.1/card/{{ $user->image }}" />
          @else
          <img style="width:20mm;  padding-right: 1mm;" src="http://127.0.0.1/images/blank.jpg" />
          @endif

        </div>
        <div style="height:7mm; padding-left: 1mm; "> Authorised by: <img style="height:10mm; vertical-align:middle;" src="images/signature.png"> </div>
      </div>
      <div style="display: inline-block; padding-left: 1mm; ">
        This card confirms the holder is a member of Wildlife Rescue South Coast Inc. and is authorised to act on our behalf.<br />
        See reverse of card for conditions / restrictions of this membership.<br />
        <strong>Expiry Date: 30</strong><strong>th</strong> <strong>June 2021</strong><br />
        <div style="color:red; text-align:center;"><strong>South Coast 0418 427 214 &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;FSC 0417 238 921</strong></div>
      </div>
    </div>
    <div class="column">
      <h3>Conditions of Membership</h3>
      <h4>The WRSC member:</h4>
      @if($user->memberType->name == 'Junior')
      <ul>
        <li>Is a junior member of Wildlife Rescue South Coast.</li>
        <li>May only participate in wildlife rescue and/or rehabilitation activities only when under the supervision of a suitably trained parent / guardian.</li>
        <li>Is not eligible to vote at meetings</li>
      </ul>
      @else
      <ul>
        <li> Agrees to comply with all DPIE/NPWS Licence conditions & WRSC constitution and policies.</li>
        <li> @if(!$user->hasAuthority('Auth to rescue')) <del> @endif Is authorised to rescue native animals and must register such wildlife within 24 hours to the relevant co-ordinator.@if(!$user->hasAuthority('Auth to rescue')) </del> @endif </li>
        <li> @if(!$user->hasAuthority('Auth to care')) <del> @endif Is authorised to partake in wildlife rehabilitation @if(!$user->hasAuthority('Auth to care')) </del> @endif </li>
        <li> @if(!$user->hasAuthority('Auth to use firearm')) <del> @endif Holds a current NSW firearms licence and is authorised to assess and if required euthanase by firearm. @if(!$user->hasAuthority('Auth to use firearm')) </del> @endif </li>
        <li> Must immediately notify Dept Primary Inds at <a href="mailto:invasive.species@dpi.nsw.gov.au">invasive.species@dpi.nsw.gov.au</a> upon advice or capture of a non-native reptile and follow any instructions.</li>
        <li> Will permit the inspection of all protected animals held and any facilities associated with their care.</li>
      </ul>
      @endif

    </div>
  </div>
  @endforeach

</body>

</html>