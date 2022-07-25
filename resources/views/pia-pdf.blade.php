<!DOCTYPE html>
<html>

<head>
  <title>PIA</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400&display=swap"
    rel="stylesheet" />
  <style>
    body {
      /*width: 700px;*/
      color: #010101;
      margin: 0;
    }

    .parent-table {
      padding: 0;
      padding-left: 20px;
      padding-right: 20px;
      /*padding-bottom: 10px;*/
    }

    table,
    tr {
      width: 100%;
      page-break-inside: auto;
      /*max-width: calc(700px - 72px);*/
    }

    tr {
      width: 100%;
      /*min-width: 700px;*/
      /*max-width: 700px;*/
    }

    td {
      vertical-align: top;
    }

    * {
      font-family: 'Lato', Arial, Helvetica, sans-serif;
      font-family: 'Lato', sans-serif;
      font-size: 9px;
    }

    h4 {
      font-size: 11px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    li::marker {
      font-weight: 700;
    }

    p {
      line-height: 10px;
      margin: 0;
      margin-bottom: 9px;
    }

    .unordered-list,
    .ordered-list,
    ul,
    ol {
      padding-inline-start: 0px;
      padding: 0;
      margin: 0;
    }

    ol,
    ul {
      padding-left: 4px;
    }

    li {
      margin-left: 16px;
      margin-bottom: 8px;
      line-height: 11px;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .align-bottom {
      vertical-align: bottom;
    }

    html {
      background: #dae0e7;
    }

    table {
      background: #ffffff;
    }

    table.collapse {
      border-collapse: collapse;
    }

    .border {
      border: 1px solid black;
    }

    .border-bottom {
      border-bottom: 1px solid black;
    }

    .border-right {
      border-right: 1px solid black;
    }

    .w-1\/2 {
      width: 50%;
    }

    .w-1\/5 {
      width: 20%;
    }

    .text-blue {
      color: #19599D;
    }

    .bg-gray {
      background-color: #EBEBEB;
    }

    h1 {
      font-size: 1.2rem;
      margin: 0;
    }

    h2 {
      color: #19599D;
      font-size: 1.1rem;
      margin: 0;
    }
  </style>
</head>

<body>
  <table class="quote-wrapper-table parent-table">
    <tr class="header">
     <td>
      <table>
        <tr>
          <td class="align-bottom"><h1>EnergySmart Post Installation Audit.</h1></td>
          <td class="text-right align-bottom">
            <strong>PIA / Code</strong>:
            {{$deal['dealname']}}
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td>
            <table>
              <tr>
                <td><strong>Home Owner</strong></td>
                <td>{{ $deal['owner_name'] ?? '' }}</td>
              </tr>
              <tr>
                <td><strong>House Address</strong></td>
                <td>{{ $deal['street_address'] ?? '' }}</td>
              </tr>
            </table>
          </td>
          <td>
            <table>
              <tr>
                <td><strong>Occupant name:</strong></td>
                <td>{{ $occupant['firstname'] ?? '' }} {{ $occupant['lastname'] ?? '' }}</td>
              </tr>
              <tr>
                <td><strong>Owner / Tenant</strong></td>
                <td>{{ $occupant['ownership_status'] ?? '' }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td>
            <table>
              <tr>
                <td><strong>Home phone</strong></td>
                <td>{{ $deal['owner_contact_number'] ?? '' }}</td>
              </tr>
              @isset($landlord)
              <tr>
                <td><strong>Landlord contact phone</strong></td>
                <td>{{ $owner['phone'] ?? '' }}</td>
              </tr>
              @endisset
              <tr>
                <td><strong>Assesment &amp; hazard ID sighted</strong></td>
                <td>{{ $deal['pia___h__s_finish___assessment___hazard_id_sighted'] ?? '' }}</td>
              </tr>
            </table>
          </td>
          <td>
            <table>
              @isset($deal['owner_mobile'])
              <tr>
                <td><strong>Mobile</strong></td>
                <td>{{ $deal['owner_mobile'] ?? '' }}</td>
              </tr>
              @endisset
              <tr>
                <td><strong>Install date</strong></td>
                <td>
                @isset($deal['installation_booked_date'])
                  {{ date_format(date_create($deal['installation_booked_date']), 'd-m-Y') }}
                @endisset
                </td>
              </tr>
              <tr>
                <td><strong>House levels</strong></td>
                <td>{{ $deal['insulation_assessment___site_assessment___storeys'] ?? '' }}</td>
              </tr>
            </table>
          </td>
          <td>
            <table>
              <tr>
                <td><strong>Postcode</strong></td>
                <td>{{ $deal['post_code'] ?? '' }}</td>
              </tr>
              <tr>
                <td><strong>Decade Build</strong></td>
                <td>{{ $deal['insulation_assessment___site_assessment___decade_built'] ?? '' }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
     </td>
    </tr>
    {{-- /header --}}
    <table class="border collapse">
      <tr class="border-bottom">
        <td class="w-1/2 border-right">
          <table class="collapse">
            <tr>
              <td>
                <h2>Ceiling Solution Installed</h2>
                Insulation fitting: {Joist_Fit}
              </td>
              <td class="text-center">
                @isset($installed_types['Ceiling'])
                  <strong>{{ $deal['insulation_assessment___ceiling___insulation_work_necessary'] }}</strong>
                @endisset
              </td>
            </tr>
          </table>

          @isset($products['Ceiling'])
          <table>
            <tr class="text-blue">
              <td>Brand Installed is:</td>
              <td class="text-center">m&sup2; assessed:</td>
              <td class="text-center w-1/5">m&sup2; audited:</td>
            </tr>
            @foreach($products['Ceiling'] as $product => $val)
            <tr>
              <td>{{htmlspecialchars_decode($product)}}</td>
              <td class="text-center">{{$val['Quoted'] ?? '-'}}</td>
              <td class="text-center">{{$val['Installed'] ?? '-'}}</td>
            </tr>
            @endforeach
          </table>
          @endisset

          <table class="collapse border-bottom">
            <tr>
              <td class="text-right">Correct product used as per Q&amp;A manual</td>
              <td class="text-center w-1/5"><strong>{{ $deal['pia___ceiling___was_correct_ceiling_product_installed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Product label correctly fixed on site</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___installer_and_manufacturers_label_present'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td colspan="2">
                {{-- Electrical fittings --}}
                <table class="bg-gray">
                  <tr class="text-blue">
                    <td>Electrical fittings (incl auxiliary device and ceiling space walls)</td>
                    <td class="text-center">Qty</td>
                    <td class="text-center w-1/5">Clearance</td>
                  </tr>
                  <tr>
                    <td >Recessed Down Lights Type 1</td>
                    <td class="text-center">{{ $deal['pia___ceiling___quantity_of_ceiling_rdl'] }}</td>
                    <td class="text-center">{{ $deal['pia___ceiling___clearance_to_ceiling_rdl'] }}</td>
                  </tr>
                  {{-- <tr>
                    <td >Recessed Down Lights Type 2</td>
                    <td class="text-center">{{ $deal['fieldname'] ?? '' }}</td>
                    <td class="text-center">{{ $deal['fieldname'] ?? '' }}</td>
                  </tr> --}}
                  <tr>
                    <td >Other Critical Devices</td>
                    <td class="text-center">{{ $deal['pia___ceiling___quantity_of_other_ceiling_cd'] }}</td>
                    <td class="text-center">{{ $deal['pia___ceiling___clearance_to_other_ceiling_cd'] }}</td>
                  </tr>
                  <tr>
                    <td >Chimneys and flues</td>
                    <td class="text-center">{{ $deal['pia___ceiling___quantity_of_chimney_and_flue'] }}</td>
                    <td class="text-center">{{ $deal['pia___ceiling___clearance_to_chimney_and_outer_faces_of_flue'] }}</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td class="text-right">Is product installed on funding agreement</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___is_product_installed_on_funding_agreement_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation in ceiling space with foil as underlay</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___insulation_installed_in_ceiling_space_with_foil_as_roof_underlay_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Was there existing insulation in ceiling</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___was_there_existing_insulation_in_ceiling_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Gaps &gt;50mm in existing insulation filled</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___gaps___50mm_width_in_existing_insulation_filled_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any insulation touching roofing materials</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___any_insulation_touching_roofing_materials_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Top plate covered (must maintain 25mm air gap)</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___top_plate_covered_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Blanket blocked off i.e. no air gap on top plate</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___no_air_movement_between_insulation_and_ceiling_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Existing insulation refitted/levelled/removed?</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___existing_insulation_refitted_levelled_damp_insulation_removed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Recessed wall + ceiling spaces complete</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___recessed_space_insulated_down_and_across'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Access correctly insulated</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___was_ceiling_access_hatch_insulated_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation installed under header tank</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___insulation_installed_under_header_tank'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Good friction fits - sides and ends, no gaps</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___good_friction_fits_in_ceiling'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Tightly fitted between ceiling joists/runners</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___tightly_fitted_between_joists_ceiling_runners_and_strong_backs_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Installation debris removed</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___installation_debris_removed_from_ceiling_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any significant gaps, tucks, or folds</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___any_significant_gaps__tucks_or_folds_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any open air pockets along perimeter &amp; edges</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___any_open_air_pockets_along_perimeter_and_edges_'] ?? '-' }}</strong></td>
            </tr>
            <tr class="border-bottom">
              <td class="text-right">Does installation comply with NZS 4246</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling___ceiling_installation_meets_nz_4246_intent_'] ?? '-' }}</strong></td>
            </tr>
          </table>

          <table class="collapse border-bottom">
            <tr>
              <td>
                <h2>Pipe Lagging Installed</h2>
              </td>
              <td class="text-center w-1/5"><strong>{{ $deal['fieldname'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Laggin fixed and taped properly</td>
              <td class="text-center"><strong>{{ $deal['pia___other_products___pipe_lagging_properly_fixed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Lagging installed as per climate zone</td>
              <td class="text-center"><strong>{{ $deal['pia___other_products___pipe_lagging_as_per_climate_zone_requirements_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">
                m (lineal) assessed: {{$deal['insulation_assessment___other_measures___hwc_pipe_lagging_req'] ?? '-'}}
                &nbsp;&nbsp;&nbsp;
                m audited: {{$deal['pia___other_products___length_of_lagging_installed'] ?? '-'}}
              </td>
              <td class="text-center"><strong>{{ $deal['fieldname'] ?? '-' }}</strong></td>
            </tr>
          </table>
          <table class="collapse">
            <tr>
              <td>
                <h2>Ceiling Wall Installed</h2>
              </td>
              <td class="text-center w-1/5"><strong>{{ $deal['pia___ceiling_wall___ceiling_space_wall_insulation_installed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Is product installed on the funding agreement</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___is_product_installed_on_the_funding_agreement'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Product fastened into place with full contact</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___product_fastened_into_place_with_full_contact'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any significant gaps, tucks or folds</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___any_significant_gaps__tucks_or_folds'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Installer and Manufacturer Labels Present</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___installer_and_manufacturer_labels_present'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation Compressed</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___insulation_compressed'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation meets NZS4246</td>
              <td class="text-center"><strong>{{ $deal['pia___ceiling_wall___insulation_meets_nzs4246'] ?? '-' }}</strong></td>
            </tr>
          </table>
        </td>

    
        <td class="w-1/2">
          <table>
            <tr>
              <td>
                <h2>Underfloor Installed</h2>
              </td>
              <td class="text-right" colspan="2">
                @isset($installed_types['Underfloor'])
                  -
                @else
                  <strong>{{ $deal['insulation_assessment___underfloor___why_is_space_not_accessible']}}</strong>
                @endisset
              </td>
            </tr>

            @isset($products['Underfloor'])
              <tr class="text-blue">
                <td>Brand Installed is:</td>
                <td class="text-center">m&sup2; assessed:</td>
                <td class="text-center w-1/5">m&sup2; audited:</td>
              </tr>
              @foreach($products['Underfloor'] as $product => $val)
                <tr>
                  <td>{{htmlspecialchars_decode($product)}}</td>
                  <td class="text-center">{{$val['Quoted'] ?? '-'}}</td>
                  <td class="text-center">{{$val['Installed'] ?? '-'}}</td>
                </tr>
                @endforeach
            @endisset
          </table>

          <table>
            <tr>
              <td class="text-right">Correct product used as per Q&amp;A manual</td>
              <td class="text-center w-1/5"><strong>{{ $deal['fieldname'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Product label correctly fixed on site</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___installer_and_manufacturer_s_label_present_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">All accesible areas done</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___all_accessible_underfloor_areas_done_'] ?? '-' }}</strong></td>
            </tr>
          </table>

          <table class="bg-gray">
            <tr class="text-blue">
              <td>Electrical fittings (incl auxiliary device and subfloor space)</td>
              <td class="text-center">Qty</td>
              <td class="text-center w-1/5">Clearance</td>
            </tr>
            <tr>
              <td>Underfloor Lights</td>
              <td class="text-center">{{$deal['pia___underfloor___quantity_of_underfloor_cd'] ?? 0}}</td>
              <td class="text-center">{{$deal['pia___underfloor___clearance_to_underfloor_cd'] ?? 0}}</td>
            </tr>
          </table>

          <table class="border-bottom">
            <tr>
              <td class="text-right">Is product installed on funding agreement</td>
              <td class="text-center w-1/5"><strong>{{ $deal['pia___underfloor___is_product_installed_on_funding_agreement_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Clearance of 100mm maintained around pipes</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___clearances_maintained_to_underfloor_plumbing_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Installed to bottom plate</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___product_installed_to_bottom_plate_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any significant gaps in Insulation</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___any_significant_gaps_underfloor'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Has the product been stapled correctly</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___has_the_product_been_stabled_correctly_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any insulation hanging below floor joists</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___any_folds_too_big_with_insulation_hanging_below_joists_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any sagging in underfloor insulation</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___any_sagging_in_underfloor_insulation_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Good friction fits - sides and ends, no gaps</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___good_friction_fits_underfloor_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Installation debris removed</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___underfloor_insulation_debris_removed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Existing insulation remaining</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___existing_insulation_remaining_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">If subfloor not encl, prod suitable open-perimeter</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___is_subfloor_not_enclosed__product_suitable_for_open_perimeter_floor_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Service area prod group # &lt;3 or non combustible</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___service_area_product_group_number__3_or_non_combustible_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation in full contact under floor</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___insulation_in_full_contact_under_floor_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation compressed?</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___insulation_compressed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Does installation comply with NZS 4246</td>
              <td class="text-center"><strong>{{ $deal['pia___underfloor___underfloor_insulation_meets_nz_4246_intent_'] ?? '-' }}</strong></td>
            </tr>
          </table>

          <table class="border-bottom collapse">
            <tr>
              <td class=""><h2>Moisture Barrier Installed</h2></td>
              <td class="text-center w-1/5"><strong>{{ $deal['pia___other_products___was_gvb_installed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Does home require GVB as per the Q&amp;A manual</td>
              <td class="text-center"><strong>{{ $deal['pia___other_products___does_qa_manual_recommend_gvb_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">
                m&sup2; assessed:
                {{$deal['pia___underfloor___insulation_quantity']}}
                &nbsp;&nbsp;&nbsp;m&sup2;
                audited: {{$deal['pia___other_products___gvb_installed_quantity'] ?? 0}}
              </td>
              <td class="text-center">
                {{-- <strong>{{ $deal['fieldname'] ?? '-' }}</strong> --}}
              </td>
            </tr>
            <tr>
              <td class="text-right">Installation debris removed</td>
              <td class="text-center"><strong>{{ $deal['pia___other_products___gvb_installation_debris_removed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Does installation comply with NZS 4246</td>
              <td class="text-center"><strong>{{ $deal['pia___other_products___gvb_installed_as_per_nz_4246_'] ?? '-' }}</strong></td>
            </tr>
          </table>

          <table class="collapse">
            <tr>
              <td class=""><h2>Sub Floor Wall Installed</h2></td>
              <td class="text-center w-1/5"><strong>{{ $deal['pia___subfloor_wall___was_subfloor_space_wall_insulation_installed_'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Is product installed correct as per EECA Spec</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___is_product_installed_correct_as_per_eeca_spec'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Product label correctly fixed on site</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___product_label_correctly_fixed_on_site'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Service area prod group # &lt; 3 or non combustible</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___service_area_prod_group_____3_or_non_combustible'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Product fastened into place with full contact</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___product_fastened_into_place_with_full_contact'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation Compressed</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___insulation_compressed'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Good Friction Fits</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___good_friction_fits'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Any significant gaps, tucks or folds</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___any_significant_gaps__tucks_or_folds'] ?? '-' }}</strong></td>
            </tr>
            <tr>
              <td class="text-right">Insulation meets NZS4246</td>
              <td class="text-center"><strong>{{ $deal['pia___subfloor_wall___insulation_meets_nzs4246'] ?? '-' }}</strong></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr class="border-bottom">
        <td colspan="2">
          <h2>Comments section for all measures installed</h2>
          {{$deal['pia___other_products___gvb_comments'] ?? '-'}}
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <table>
            <tr>
              <td><h2>Auditor Declaration Section</h2></td>
              <td class="text-center">For all measure installed the audit has 
                <strong>
                  Passed
                </strong>
              </td>
              <td class="text-center">Audit Date 
                @isset($deal['pia___finalise___finalisation_date'])
                  {{ date_format(date_create($deal['pia___finalise___finalisation_date']), 'd-m-Y') }}
                @endisset
              </td>
            </tr>
          </table>
          {{$deal['pia___finalise___finalisation_comments'] ?? ''}}
          <table class="w-1/2">
            <tr>
              <td>Auditor's name: {{$deal['pia___finalise___finalised_by'] ?? ''}}</td>
              <td>
                @isset($deal['pia___finalise___branch_manager_signature'])
                @php
                  $signature_url = json_decode($deal['pia___finalise___branch_manager_signature']);
                @endphp
                <img src="{{$signature_url[0]}}" alt="">
                @endisset
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </table>

</body>

</html>