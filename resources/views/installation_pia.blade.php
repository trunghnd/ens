<!DOCTYPE html>
<html>
<head>
    <title>Installation | PIA</title>
</head>
<body>
<!-- quote -->


<?php

$contentWidth = 755;


?>




<style>

    @page { margin: 10px; }
body { margin: 10px }


    *{
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 8.5px;
      line-height: 100%;
    }

    p{
        line-height: 150%;
    }
    small{
        font-size:0.8em;
        color: inherit;
    }
    h2{
        font-size: 1.5em;
        margin: 0 0 5px 0;
        line-height: 100%;
    }
    strong{
        font-weight: bold;
        color:inherit;
		line-height: inherit;
    }


    h3{
        font-size: 1.3em;
        margin: 0 0 0 0;
        line-height: 100%;
    }


    p{
        margin:0 0 1em;
    }
    .unordered-list,
    .ordered-list {
        padding:0;
        margin:0;
    }
    .unordered-list {
        list-style: disc;
    }
    .unordered-list.circle {
        list-style: circle;
    }
    .unordered-list.square {
        list-style: square;
    }

    .unordered-list li,
    .ordered-list li{
        margin-left:30px;
        margin-bottom: 10px;
        line-height: 150%;
    }
    .unordered-list li:last-child,
    .ordered-list li:last-child{
        margin-bottom: 1em;
    }
    .copyright{
        font-size: 0.8em;
        text-align: center;
        font-style: italic;
    }

    em,i{
        font-style: italic;
        line-height: inherit;
    }




html{
    background:  lightgrey;
}

table{
    width:  100%;
}


table td, table td * {
    vertical-align: top;
}



td, th{
    padding:  5px;
    text-align: left;
}


.col{
    padding:  0;
    margin:  0;
}



.checklist {

}


.checklist tr td:nth-child(2), .checklist tr th:nth-child(2) {
 
    width:  80px;   
    text-align: center;
    font-size: 1.2em;
    font-weight: bold;
}

.checklist tr td:nth-child(1), .checklist tr th:nth-child(1) {
     
    width:  calc(100% - 80px);  
    text-align: right;

}




.wrap{
    width:{{$contentWidth}}px;
    margin:  0px auto;
    background:  white;

}




.bt{
    border-top: solid 1px black;
}

.br{
    border-right: solid 1px black;
}

.bb{
    border-bottom: solid 1px black;
}

.bl{
    border-left: solid 1px black;
}


.grey_background{
    background:  #eaeaea;
}


.blue_heading{
    color:  #0b58a2;
}


.col-2 tr{
    width:  100%;
}


.col-2 td, .col-2 th{
    width:  50%;
}



.col-2{
        width:{{$contentWidth}}px;
        border: 0;
    }


.col-4 td{
    width:  25%;
}


</style>

<div class="wrap">
    

<table cellpadding="0" cellspacing="0" class="">

    <tr>
        <th>
            <h2>EnergySmart Post Installation Audit</h2>

        </th>
        <th>
            <h2>PIA / Code 409490Pal</h2>
        </th>
    </tr>

</table>


<table cellpadding="0" cellspacing="0" class="">

    <tr>
        <th>
            Home Owner
        </th>
        <td>
            {{$first_name ?? ''}} {{$last_name ?? ''}}
        </td>
        <th>
            Occupant name
        </th>
        <td>
            John and Olimpia Green
        </td>
    </tr>

    <tr>
        <th>
            House Address
        </th>
        <td>
            {{$address ?? ''}}
        </td>
        <th>
            Owner / Tenant
        </th>
        <td>
            Owner / Occupier
        </td>
    </tr>

</table>


<table cellpadding="0" cellspacing="0" class="">

    <tr>
        <th>
            Home phone
        </th>
        <td>
            06-3567869
        </td>
        <th>
            Mobile
        </th>
        <td>
            0212685782
        </td>
        <th>
            Postcode
        </th>
        <td>
            4412
        </td>
    </tr>

    <tr>
        <th>
            Landlord contact phone
        </th>
        <td>
            0212685782
        </td>
        <th>
            Install date
        </th>
        <td>
            20/12/2019
        </td>
        <th>
            Year built 
        </th>
        <td>
            1970
        </td>
    </tr>

    <tr>
        <th>
            Assessment & hazard ID sighted
        </th>
        <td>
            Yes
        </td>
        <th>
            House levels
        </th>
        <td>
            1
        </td>
        <th>

        </th>
        <td>

        </td>
    </tr>



</table>


<table cellpadding="0" cellspacing="0" class="col-2">

    <tr>
        <td class="bt br bb bl col"><!--left column-->


            <table cellpadding="0" cellspacing="0" class="header-table border">
                <tr>
                    <th class="blue_heading">
                        <h3>Ceiling Solution Installed</h3>
                    </th>
                    <th>
                        <h3>Total Fill Solution</h3>
                    </th>
                </tr>
                <tr>
                    <td>
                        Insulation fitting: Joist Fit
                    </td>
                    <td>

                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" class="header-table">
                <tr class="blue_heading">
                    <th>
                        Brand Installed is:
                    </th>
                    <th>
                        m² assessed:
                    </th>
                    <th>
                        m² audited:
                    </th>
                </tr>
                <tr>
                    <td>
                        Tasman Pink Batts Segment R3.6
                    </td>
                    <td>
                        94 
                    </td>
                    <td>
                        94
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" class="checklist">
                <tr>
                    <td>
                        Correct product used as per Q&A manual
                    </td>
                    <td>
                        
                        {{$pia___ceiling___was_correct_ceiling_product_installed_ ?? '-'}} 
                    
                    </td>
                </tr>
                <tr>
                    <td>
                        Product label correctly fixed on site 
                    </td>
                    <td>

                        {{$pia___ceiling___installer_and_manufacturers_label_present ?? '-'}}

                    </td>
                </tr>
            </table>


            <table class="grey_background" cellpadding="0" cellspacing="0" class="header-table">
                <tr class="blue_heading">
                    <th>
                        Electrical fittings (incl auxiliary device
and ceiling space walls) 
                    </th>
                    <th>
                        Qty 
                    </th>
                    <th>
                        Clearance
                    </th>
                </tr>
                <tr>
                    <td>
                        Recessed Down Lights Type 1
                    </td>
                    <td>
                        {{$pia___ceiling___quantity_of_ceiling_rdl ?? '0'}}  
                    </td>
                    <td>
                        {{$pia___ceiling___clearance_to_ceiling_rdl ?? '0'}} 
                    </td>
                </tr>
                <tr>
                    <td>
                        Other Critical Devices
                    </td>
                    <td>
                        {{$pia___ceiling___quantity_of_other_ceiling_cd ?? '0'}} 
                    </td>
                    <td>
                        {{$pia___ceiling___clearance_to_other_ceiling_cd ?? '0'}} 
                    </td>
                </tr> 
                <tr>
                    <td>
                        Chimneys and flues
                    </td>
                    <td>
                        {{$pia___ceiling___quantity_of_chimney_and_flue ?? '0'}}  
                    </td>
                    <td>
                        {{$pia___ceiling___clearance_to_chimney_and_outer_faces_of_flue ?? '0'}}
                    </td>
                </tr>                               
            </table>



<table class="bb checklist" cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <td>
Is product installed on funding agreement
    </td>
    <td>
        {{$pia___ceiling___is_product_installed_on_funding_agreement_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Insulation in ceiling space with foil as underlay
    </td>
    <td>
        {{$pia___ceiling___insulation_installed_in_ceiling_space_with_foil_as_roof_underlay_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Was there existing insulation in ceiling
    </td>
    <td>
        {{$pia___ceiling___was_there_existing_insulation_in_ceiling_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Gaps >50mm in existing insulation filled
    </td>
    <td>
        {{$pia___ceiling___gaps___50mm_width_in_existing_insulation_filled_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Any insulation touching roofing materials
    </td>
    <td>
        
        {{$pia___ceiling___any_insulation_touching_roofing_materials_ ?? '-'}}

    </td>
</tr>
<tr>
    <td>
Top plate covered (must maintain 25mm air gap)
    </td>
    <td>
        {{$pia___ceiling___top_plate_covered_ ?? '-'}}
    </td>
</tr>
<tr>
    <td>
Blanket blocked off i.e. no air gap on top plate
    </td>
    <td>
        {{$pia___ceiling___top_plate_covered_ ?? '-'}}
    </td>
</tr>
<tr>
    <td>
Existing insulation refitted/levelled/removed?
    </td>
    <td>

        {{$pia___ceiling___existing_insulation_refitted_levelled_damp_insulation_removed_ ?? '-'}} 

    </td>
</tr>
<tr>
    <td>
Recessed wall + ceiling spaces complete
    </td>
    <td>
        {{$pia___ceiling___recessed_space_insulated_down_and_across ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Access correctly insulated
    </td>
    <td>
        {{$pia___ceiling___was_ceiling_access_hatch_insulated_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Insulation installed under header tank
    </td>
    <td>
        
        {{$pia___ceiling___insulation_installed_under_header_tank ?? '-'}} 

    </td>
</tr>
<tr>
    <td>
Good friction fits — sides and ends, no gaps
    </td>
    <td>
        
        {{$pia___underfloor___good_friction_fits_underfloor_ ?? '-'}}

    </td>
</tr>
<tr>
    <td>
Tightly fitted between ceiling joists/runners
    </td>
    <td>
        
        {{$pia___ceiling___tightly_fitted_between_joists_ceiling_runners_and_strong_backs_ ?? '-'}}

    </td>
</tr>
<tr>
    <td>
Installation debris removed
    </td>
    <td>
        
        {{$pia___ceiling___installation_debris_removed_from_ceiling_ ?? '-'}}

    </td>
</tr>
<tr>
    <td>
Any significant gaps, tucks, or folds
    </td>
    <td>
        
        {{$pia___ceiling___any_significant_gaps__tucks_or_folds_ ?? '-'}}

    </td>
</tr>
<tr>
    <td>
Any open air pockets along perimeter & edges N Does installation comply with NZS 4246
    </td>
    <td>
        
        {{$pia___ceiling___any_open_air_pockets_along_perimeter_and_edges_ ?? '-'}}

    </td>
</tr>
</table>



<table class="checklist" cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <th class="blue_heading">
<h3>Pipe Lagging Installed</h3>
    </th>
    <th>
        {{$pia___other_products___was_pipe_lagging_installed_ ?? '-'}} 
    </th>
</tr>
<tr>
    <td>
Lagging fixed and taped properly
    </td>
    <td>
        {{$pia___other_products___pipe_lagging_properly_fixed_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Lagging installed as per climate zone
    </td>
    <td>
        {{$pia___other_products___pipe_lagging_as_per_climate_zone_requirements_ ?? '-'}}
    </td>
</tr>
</table>


<table class="bb col-4" cellpadding="0" cellspacing="0">
<tr>
    <td>
        m (lineal) assessed:
    </td>
    <td>
        -
    </td>
    <td>
        m audited:
    </td>
    <td>
        -
    </td>
</tr>

</table>


<table cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <th class="blue_heading">
<h3>Ceiling Wall Installed</h3>
    </th>
    <th>
        {{$pia___ceiling_wall___ceiling_space_wall_insulation_installed_ ?? '-'}} 
    </th>
</tr>
<tr>
    <td>
Is product installed on the funding agreement
    </td>
    <td>
        {{$pia___ceiling___is_product_installed_on_funding_agreement_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Product fastened into place with full contact
    </td>
    <td>
        {{$pia___ceiling_wall___product_fastened_into_place_with_full_contact ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Any significant gaps, tucks or folds
    </td>
    <td>
        {{$pia___ceiling_wall___any_significant_gaps__tucks_or_folds ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Installer and Manufacturer Labels Present
    </td>
    <td>
        {{$pia___ceiling_wall___installer_and_manufacturer_labels_present ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Insulation Compressed
    </td>
    <td>
        {{$pia___ceiling_wall___insulation_compressed ?? '-'}}   
    </td>
</tr>
<tr>
    <td>
Insulation meets NZS4246
    </td>
    <td>
        {{$pia___ceiling_wall___insulation_meets_nzs4246 ?? '-'}}  
    </td>
</tr>

</table>





        </td><!--end left column-->

        <td class="bt br bb col"><!--right column-->



            <table cellpadding="0" cellspacing="0" class="header-table">
                <tr>
                    <th class="blue_heading">
                        <h3>Under floor Installed</h3>
                    </th>
                    <th>
                        <h3>None - underfloor needs insulating</h3>
                    </th>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" class="header-table">
                <tr class="blue_heading">
                    <th>
                        Brand Installed is:
                    </th>
                    <th>
                        m² assessed:
                    </th>
                    <th>
                        m² audited:
                    </th>
                </tr>
                <tr>
                    <td>
                        PolyKing UFL R1.4
                    </td>
                    <td>
                        94 
                    </td>
                    <td>
                        94
                    </td>
                </tr>
                <tr class="blue_heading">
                    <td>
                        Total
                    </td>
                    <td>
                        94 
                    </td>
                    <td>
                        94
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" class="checklist">
                <tr>
                    <td>
                        Correct product used as per Q&A manual
                    </td>
                    <td>
                        ??? 
                    </td>
                </tr>
                <tr>
                    <td>
                        Product label correctly fixed on site 
                    </td>
                    <td>
                        {{$pia___underfloor___installer_and_manufacturer_s_label_present_ ?? '-'}}  
                    </td>
                </tr>
                <tr>
                    <td>
                        All accessible areas done
                    </td>
                    <td>
                        {{$pia___underfloor___all_accessible_underfloor_areas_done_ ?? '-'}} 
                    </td>
                </tr>
            </table>

            <table class="grey_background" cellpadding="0" cellspacing="0" class="header-table">
                <tr class="blue_heading">
                    <th>
                        Electrical fittings (incl auxiliary device
and subfloor space) 
                    </th>
                    <th>
                        Qty 
                    </th>
                    <th>
                        Clearance
                    </th>
                </tr>
                <tr>
                    <td>
                        Underfloor Lights
                    </td>
                    <td>
                        0 
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                             
            </table>



<table class="bb checklist" cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <td>
Is product installed on funding agreement
    </td>
    <td>
        {{$pia___underfloor___is_product_installed_on_funding_agreement_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Clearance of 100mm maintained around pipes
    </td>
    <td>
        {{$pia___underfloor___clearances_maintained_to_underfloor_plumbing_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Installed to bottom plate
    </td>
    <td>
        {{$pia___underfloor___product_installed_to_bottom_plate_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Any significant gaps in Insulation
    </td>
    <td>
        {{$pia___underfloor___all_accessible_underfloor_areas_done_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Has the product been stapled correctly
    </td>
    <td>
        {{$pia___underfloor___has_the_product_been_stabled_correctly_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Any insulation hanging below floor joists
    </td>
    <td>
        {{$pia___underfloor___any_folds_too_big_with_insulation_hanging_below_joists_ ?? '-'}}   
    </td>
</tr>
<tr>
    <td>
Any sagging in underfloor insulation
    </td>
    <td>
        {{$pia___underfloor___any_sagging_in_underfloor_insulation_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Good friction fits — sides and ends, no gaps
    </td>
    <td>
        {{$pia___underfloor___good_friction_fits_underfloor_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Installation debris removed 
    </td>
    <td>
        {{$pia___underfloor___underfloor_insulation_debris_removed_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Existing insulation remaining
    </td>
    <td>
        {{$pia___underfloor___existing_insulation_remaining_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
If subfloor not encl, prod suitable open-perimeter
    </td>
    <td>
        {{$pia___underfloor___is_subfloor_not_enclosed__product_suitable_for_open_perimeter_floor_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Service area prod group # <3 or non combustible
    </td>
    <td>
        {{$pia___underfloor___service_area_product_group_number__3_or_non_combustible_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Insulation in full contact under floor
    </td>
    <td>
        {{$pia___underfloor___insulation_in_full_contact_under_floor_ ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Insulation compressed?
    </td>
    <td>
        
        {{$pia___underfloor___insulation_compressed_ ?? '-'}}   
    </td>
</tr>
<tr>
    <td>
Does installation comply with NZS 4246
    </td>
    <td>
        {{$pia___underfloor___underfloor_insulation_meets_nz_4246_intent_ ?? '-'}}
    </td>
</tr>


</table>



<table cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <th class="blue_heading">
<h3>Moisture Barrier Installed
    </th>
    <th>
        {{$pia___other_products___was_gvb_installed_ ?? '-'}} 
    </th>
</tr>

<tr>
    <td>
Does home require GVB as per the Q&A manual
    </td>
    <td>
        {{$pia___other_products___does_qa_manual_recommend_gvb_ ?? '-'}}
    </td>
</tr>

</table>

<table class="bb col-4" cellpadding="0" cellspacing="0">
<tr>
    <td>
        m (lineal) assessed:
    </td>
    <td>
        -
    </td>
    <td>
        m audited:
    </td>
    <td>
        -
    </td>
</tr>

</table>

<table cellpadding="0" cellspacing="0" class="checklist">

<tr>
    <td>
Installation debris removed
    </td>
    <td>
        {{$pia___other_products___gvb_installation_debris_removed_ ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Does installation comply with NZS 4246
    </td>
    <td>
        {{$pia___other_products___gvb_installed_as_per_nz_4246_ ?? '-'}}  
    </td>
</tr>

</table>



<table cellpadding="0" cellspacing="0" class="checklist">
<tr>
    <th class="blue_heading">
<h3>Sub Floor Wall Installed</h3>
    </th>
    <th>
        {{$pia___subfloor_wall___was_subfloor_space_wall_insulation_installed_ ?? '-'}}  
    </th>
</tr>
<tr>
    <td>
Is product installed correct as per EECA Spec
    </td>
    <td>
        {{$pia___subfloor_wall___is_product_installed_correct_as_per_eeca_spec ?? '-'}}
    </td>
</tr>
<tr>
    <td>
Product label correctly fixed on site
    </td>
    <td>
        {{$pia___subfloor_wall___product_label_correctly_fixed_on_site ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Service area prod group # < 3 or non combustible
    </td>
    <td>
        {{$pia___subfloor_wall___service_area_prod_group_____3_or_non_combustible ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Product fastened into place with full contact
    </td>
    <td>
        {{$pia___subfloor_wall___product_fastened_into_place_with_full_contact ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Insulation Compressed
    </td>
    <td>
        {{$pia___subfloor_wall___insulation_compressed ?? '-'}} 
    </td>
</tr>
<tr>
    <td>
Good Friction Fits
    </td>
    <td>
        {{$pia___subfloor_wall___good_friction_fits ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Any significant gaps, tucks or folds
    </td>
    <td>
        {{$pia___subfloor_wall___any_significant_gaps__tucks_or_folds ?? '-'}}  
    </td>
</tr>
<tr>
    <td>
Insulation meets NZS4246 
    </td>
    <td>
        {{$pia___subfloor_wall___insulation_meets_nzs4246 ?? '-'}}  
    </td>
</tr>
</table>



        </td><!--end right column-->

    </tr>

</table>


<table class="bt br bb bl" cellpadding="0" cellspacing="0">
<tr>
    <th class="blue_heading">
        <h3>Comments section for all measures installed</h3>
    </th>
</tr>
<tr>
    <td>
        94m2 of 3.6 Pink Batts installed 94m2 of GVB installed 94m2 of 1.4 UFL installed Installed to NZ4246 standard Job Complete
    </td>
</tr>

</table>


<table class="bt br bb bl" cellpadding="0" cellspacing="0">
<tr>
    <td>
        <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="blue_heading">
                <h3>Auditor Declaration Section</h3>
            </td>
            <td>
                For all measure installed the audit has <strong>Passed</strong>
            </td>
            <td>
                Audit Date 20/12/2019
            </td>
        </tr>

        </table>
    </td>
</tr>

<tr>
    <td>
        I declare and undertake that the information in this post installation audit form is accurate and complete to the best of my knowledge
    </td>
</tr>

<tr>
    <td>
        <table cellpadding="0" cellspacing="0">
        <tr>
            <td>
                Auditor's name: Ben Chapman
            </td>
            <td>
                Signature Placeholder
            </td>
            <td>

            </td>
        </tr>

        </table>
    </td>
</tr>

</table>




</div><!--wrap-->



</body>
</html>


