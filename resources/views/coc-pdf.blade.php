<!DOCTYPE html>
<html lang="en">
<head>
  <title>Code of Compliance</title>
  <!-- <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->
  <style>
    <?php echo $css; ?>
    
  </style>
</head>

<body>

  <div class="wrapper">
    <div class="section section1">
      <div class="container">
        <table class="header">
          <tr>
            <td class="logos">
              <img class="logo" src="data:image/png;base64,{{$logo}}" alt="">
              <img class="rcm" src="data:image/png;base64,{{$rmc}}" alt="">
            </td>
            <td class="title">
              <h1>ELECTRICAL CERTIFICATE OF COMPLIANCE & ELECTRICAL SAFETY CERTIFICATE</h1>
            </td>
          </tr>
        </table>
        <div class="one-line highlight mask">
          <div class="solid-background">REFERENCE/CERTIFICATE ID NO.:</div>
          <div>{{$deal['dealname']}}</div>
        </div>
        <div class="one-line">
          <div>This form has been designed to be used by licensed electrical workers to certify that installations or Part installations under Part 1 or Part 2 of AS/NZS 3000 are safe to be connected to the specified system of electrical supply</div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Location Details:</div>
          <div>{{$deal['street_address']}}</div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Contact Details:</div>
          <div class="percent30">{{$deal['owner_name']}}</div><div class="highlight">{{$deal['owner_contact_number']}}</div>
        </div>

      </div>
    </div>
    <div class="section section2">
      <div class="container">
        <div class="one-line highlight mask">
          <div class="solid-background">Name of Electrical Worker:</div>
          <div class="percent30">{{$contact['firstname']}} {{$contact['lastname']}}</div>
          <div class="solid-background">Practicing Licence Number:</div>
          <div class="percent15">{{$contact['practicing_licence_number']}}</div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Phone:</div>
          <div class="percent30">
            @if (isset($contact['mobilephone']))
              {{$contact['mobilephone']}}
            @elseif (isset($contact['phone']))
              {{$contact['phone']}}
            @endif

          </div>
          <div class="solid-background">Email:</div>
          <div class="percent30">{{$contact['email']}}</div>
        </div>
        <div class="one-line">
          <div>Name and Registration Number of person supervised:</div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Name:</div>
          <div class="percent30"></div>
          <div class="solid-background">Registration Number:</div>
          <div class="percent20"></div>
        </div>
      </div>
    </div>
    <div class="section section3">
      <div class="container">
        <div class="one-line">
          <div class="bold">CERTIFICATE OF COMPLIANCE</div>
        </div>  
        <div class="one-line">
          <div class="percent30">Type of Work:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___type_of_work'] == 'Addition')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Addition
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___type_of_work'] == 'Alteration')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Alteration
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___type_of_work'] == 'New work')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            New Work
          </div>
        </div>
        <div class="one-line">
          <div class="percent30">The prescribed electrical work is:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_prescribed_electrical_work_is'] == 'Low risk')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Low Risk
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_prescribed_electrical_work_is'] == 'General')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            General
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_prescribed_electrical_work_is'] == 'High risk')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            High Risk (Specify)
          </div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Specify:</div>
          <div class="percent80">
            @if ($deal['heat_pump___coc___the_prescribed_electrical_work_is'] == 'High risk')
              {{$deal['heat_pump___coc___specify_high_risk']}}
            @endif 
          </div>
        </div>
        <div class="one-line">
          <div class="percent30">Means of compliance:</div>
          <div class="percent30">
            @if ($deal['heat_pump___coc___means_of_as_nzs_3000_compliance'] == 'Part 1')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Part 1 of AS/NZS 3000
          </div>
          <div class="percent30">
            @if ($deal['heat_pump___coc___means_of_as_nzs_3000_compliance'] == 'Part 2')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Part 2 of AS/NZS 3000
          </div>
        </div>
        <div class="one-line">
          <div class="percent50">Additional Standards of electrical code of practice were required:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___additional_standards_of_electrical_code_of_practice_were_required'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            Yes
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___additional_standards_of_electrical_code_of_practice_were_required'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            No
          </div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Specify:</div>
          <div class="percent80">
            @if ($deal['heat_pump___coc___additional_standards_of_electrical_code_of_practice_were_required'] == 'Yes')
              {{$deal['heat_pump___coc___specify_additional_standards']}}
            @endif
          </div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Date or range of dates that prescribed electrical work undertaken:</div>
          <div class="percent40">
            @isset($deal['heat_pump___coc___from_date_that_prescribed_electrical_work_undertaken'])
              @if ($deal['heat_pump___coc___from_date_that_prescribed_electrical_work_undertaken'] == $deal['heat_pump___coc___to_date_that_prescribed_electrical_work_undertaken'])
                {{date_format(date_create($deal['heat_pump___coc___from_date_that_prescribed_electrical_work_undertaken']),'l, F d Y')}}
              @else
                {{date_format(date_create($deal['heat_pump___coc___from_date_that_prescribed_electrical_work_undertaken']),'l, F d Y')}} - {{date_format(date_create($deal['heat_pump___coc___to_date_that_prescribed_electrical_work_undertaken']),'l, F d Y')}}
              @endif
            @endisset
          </div>
        </div>
        <div class="one-line">
          <div class="percent50">Contains fittings that are safe to connect to a power supply:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___contains_fittings_that_are_safe_to_connect_to_a_power_supply'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif 
            Yes
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___contains_fittings_that_are_safe_to_connect_to_a_power_supply'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            No
          </div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Specify Type of supply system:</div>
          <div class="percent60">
            @if ($deal['heat_pump___coc___contains_fittings_that_are_safe_to_connect_to_a_power_supply'] == 'Yes')
              {{$deal['heat_pump___coc___specify_type_of_supply_system']}}
            @endif 
          </div>
        </div>
        <div class="one-line">
          <div class="percent60">The installation has an earthing system that is correctly rated (where applicable):</div>
          <div class="percent15">
            @if ($deal['heat_pump___coc___the_installation_has_an_earthing_system_that_is__correctly_rated'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif  
            Yes
          </div>
          <div class="percent15">
            @if ($deal['heat_pump___coc___the_installation_has_an_earthing_system_that_is__correctly_rated'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            No
          </div>
        </div>
        <div class="one-line">
          <div class="percent75">Parts of the installation to which this certificate relates that are safe to connect to a power supply?</div>
          <div class="percent10">
            @if ($deal['heat_pump___coc___parts_of_the_installation_to_which_this_certificate_relates_that__are_safe_to_con'] == 'All')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif  
            All
          </div>
          <div class="percent10">
            @if ($deal['heat_pump___coc___parts_of_the_installation_to_which_this_certificate_relates_that__are_safe_to_con'] == 'Parts')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif 
            Parts
          </div>
        </div>
        <div class="one-line highlight mask">
          <div class="solid-background">Specify:</div>
          <div class="percent80">
            @if ($deal['heat_pump___coc___parts_of_the_installation_to_which_this_certificate_relates_that__are_safe_to_con'] == 'Parts')
              {{$deal['heat_pump___coc___specify']}}
            @endif 
          </div>
        </div>
        <div class="one-line">
          <div class="percent50">The work relies on Manufacturers instructions:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_relies_on_manufacturers_instructions'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif   
            Yes</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_relies_on_manufacturers_instructions'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif
            No
          </div>
        </div>
        <div class="one-line-no-float">
          <div>If yes – identify the instruction manual including name, date and version. Also attach a copy of manufacturer’s instructions to this certificate. (Or provide reference to readily accessible electronic format, eg Internet link.)</div>
        </div>
        <div class="one-line-no-float highlight adjust-margin">
          <div class="height1em">
            @if ($deal['heat_pump___coc___the_work_relies_on_manufacturers_instructions'] == 'Yes')
              {{$deal['heat_pump___coc___instruction_manual_name']}} |
              {{$deal['heat_pump___coc___instruction_manual_date']}} |
              {{$deal['heat_pump___coc___instruction_manual_version']}} |
              @if ($deal['heat_pump___coc___instruction_manual_file'] == 'Link')
                {{$deal['heat_pump___coc___instruction_manual_file_link']}}
              @endif 
              @if ($deal['heat_pump___coc___instruction_manual_file'] == 'Upload')
                {{$deal['heat_pump___coc___instruction_manual_file_attachment']}}
              @endif
            @endif 
          </div>
        </div>

        <div class="one-line">
          <div class="percent50">The work has been done in accordance with a certified design:</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_has_been_done_in_accordance_with_a_certified_design'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif 
            Yes
          </div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_has_been_done_in_accordance_with_a_certified_design'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif 
            No
          </div>
        </div>
        <div class="one-line-no-float">
          <div>If yes – identify the certified design including name, date and version. Also attach a copy of the certified design to this certificate.(Or provide reference to readily accessible electronic format, eg Internet link.)</div>
        </div>
        <div class="one-line-no-float  highlight adjust-margin">
          <div class="height1em">
            @if ($deal['heat_pump___coc___the_work_has_been_done_in_accordance_with_a_certified_design'] == 'Yes')
              {{$deal['heat_pump___coc___certified_design_name']}} |
              {{$deal['heat_pump___coc___certified_design_date']}} |
              {{$deal['heat_pump___coc___certified_design_version']}} |
              @if ($deal['heat_pump___coc___certified_design_file'] == 'Link')
                {{$deal['heat_pump___coc___certified_design_file_link']}}
              @endif 
              @if ($deal['heat_pump___coc___certified_design_file'] == 'Upload')
                {{$deal['heat_pump___coc___certified_design_file_attachment']}}
              @endif
            @endif 
          </div>
        </div>

        <div class="one-line">
          <div class="percent50">The work relies on a Supplier Declaration of Conformity (SDoC):</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_relies_on_a_supplier_declaration_of_conformity'] == 'Yes')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif  
            Yes</div>
          <div class="percent20">
            @if ($deal['heat_pump___coc___the_work_relies_on_a_supplier_declaration_of_conformity'] == 'No')
              <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
            @endif 
            No
          </div>
        </div>
        <div class="one-line-no-float">
          <div>If yes ‐ identify the SDoC including name, date and version OR EESS registration. Also attach a copy of the SDoC to this certificate.(Or provide reference to readily accessible electronic format, eg Internet link.)</div>
        </div>
        <div class="one-line-no-float highlight adjust-margin">
          <div class="height1em">
            @if ($deal['heat_pump___coc___the_work_relies_on_a_supplier_declaration_of_conformity'] == 'Yes')
              {{$deal['heat_pump___coc___sdoc_name']}} |
              {{$deal['heat_pump___coc___sdoc_date']}} |
              {{$deal['heat_pump___coc___sdoc_version_or_eess_registration']}} |
              @if ($deal['heat_pump___coc___sdoc_file'] == 'Link')
                {{$deal['heat_pump___coc___sdoc_file_link']}}
              @endif 
              @if ($deal['heat_pump___coc___sdoc_file '] == 'Upload')
                {{$deal['heat_pump___coc___sdoc_file_attachment']}}
              @endif
            @endif 
          </div>
        </div>

        <table class="description-results">
          <tr>
            <td class="width-work-description work-description">
              <div>Description of Work</div>
              <div class="highlight">
                {{$deal['heat_pump___coc___description_of_work']}}         
              </div>
            </td>
            <td class="width-results">
              <table class="results">
                <tr>
                  <td class="text-center" colspan="2">Test Results (Provide Values)</td>
                </tr>
                <tr>
                  <td class="width-left-results">Polarity (Independent Earth)</td>
                  <td>
                    <!-- @if ($deal['heat_pump___coc___test_results___polarity__independent_earth_'] == 'Yes')
                      <img class="check-box-image" src="data:image/png;base64,{{$checkBox}}" alt=""> 
                    @else
                    <img class="blank-check-box-image" src="data:image/png;base64,{{$blankCheckBox}}" alt=""> 
                    @endif  -->
                    
                    {{$deal['heat_pump___coc___test_results___polarity']}} 
                  </td>
                </tr>
                <tr>
                  <td class="width-left-results">Insulation Resistance</td>
                  <td class="highlight">{{$deal['heat_pump___coc___test_results___insulation_resistance']}} Ohms</td>
                </tr>
                <tr>
                  <td class="width-left-results">Earth Continuity</td>
                  <td class="highlight">{{$deal['heat_pump___coc___test_results___earth_continuity']}} Ohms</td>
                </tr>
                <tr>
                  <td class="width-left-results">Bonding</td>
                  <td class="highlight">{{$deal['heat_pump___coc___test_results___bonding']}} Ohms</td>
                </tr>
                <tr>
                  <td class="width-left-results">Fault Loop Impedance</td>
                  <td class="highlight">{{$deal['heat_pump___coc___test_results___fault_loop_impedance']}} Ohms</td>
                </tr>
                <tr>
                  <td class="width-left-results">Other (Specify)</td>
                  <td class="highlight width12">
                    @if ($deal['heat_pump___coc___test_results___other'] == 'Yes')
                      {{$deal['heat_pump___coc___test_results___specify_other']}} 
                    @endif
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>


        <div class="one-line-no-float">
          <div class="bold">By signing this document I certify that the completed prescribed electrical work to which this certificate of compliance applies has been done lawfully and safely, and the information in the certificate is correct</div>
        </div>

        <div class="one-line">
          <div class="percent50 signature">
            <div>
                @isset ($deal['installer_signature'])
                  <img class="signature-image" src="data:image/png;base64,{{$deal['installer_signature']}}" alt=""> 
                @endisset
            </div>
          </div>
          <div class="percent40">
            <div class="date">
              Date: 
              <span class="highlight">
                {{date_format(date_create($deal['pia___h___s_finish___date']),'l, F d Y')}} 
                {{$deal['pia___h___s_finish___time']}}
              </span>
            </div>
          </div>

        </div>

      </div>
    </div>
    <div class="section section4">
      <div class="container">
        <div class="one-line">
          <div class="bold">ELECTRICAL SAFETY CERTIFICATE</div>
        </div>
        <div class="one-line-no-float">
          <div>By signing this document I certify that the installation, or part of the isntallation, to which this electrical safety certificate applies is connected to a power supply and is safe to use.</div>
        </div>
        <div class="one-line">
        <div class="percent40">
          <div class="name">
            Certifiers Name: <span class="highlight">{{$deal['pia___h___s_finish___team_lead']}}</span>
          </div>
          </div>
          <div class="percent50 signature">
            <span>Certifiers Signature</span>
            <div>
              @isset ($deal['installer_signature'])
                <img class="signature-image" src="data:image/png;base64,{{$deal['installer_signature']}}" alt=""> 
              @endisset
            </div>
          </div>
          

        </div>

        <div class="one-line registration-details">
          <div class="percent30">
            <div>Certification Issue Date:</div>
            <div class="highlight">
              {{date_format(date_create($deal['installation_booked_date']),'l, F d Y')}}
            </div>
          </div>
          <div class="percent30">
            <div>Registration/Practicing licence number:</div>
            <div class="highlight">{{$contact['practicing_licence_number']}}</div>
          </div>
          <div class="percent30">
            <div>Connection Date</div>
            <div class="highlight">
              {{date_format(date_create($deal['installation_booked_date']),'l, F d Y')}} 
            </div>
          </div>


        </div>
        <div class="one-line-no-float">
          <div class="font-small">This Electrical Safety Certificate also confirms that the electrical work complies with the building code for the purposes of section 19(1)(e) of the Building Act 2004</div>
        </div>
        
        
      </div>
    </div>
  </div>

</body>
</html>

