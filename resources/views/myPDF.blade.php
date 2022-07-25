<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>

<!-- quote -->

<?php

$contentWidth = 700;


?>



<style>


    @page { margin: 20px; }
body { margin: 20px; }


    *{
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 14px;
      color: #000000;
      line-height: 100%;
    }
    p{
        line-height: 150%;
    }
    h2{
        font-size: 1.5em;
        margin: 0 0 20px;
        line-height: 120%;
    }
    h2.no-margin{
        margin:0;
    }
    h2 .product-name{
        color:#e1e34d;
        font-size: inherit;
    }
    h2.solution-heading{
        margin:10px 0;
    }
    .terms h2 {
        text-align: center;
        padding-top:20px;
        margin-top:20px;
        border-top:2px solid #e5e5e5;
    }
    .terms h2:first-of-type {
        margin-top:0;
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
    }

    .quote-table{
        width:{{$contentWidth}}px;
        border: 0;
        background-color: #74be4b;
    }
    .quote-table + p{
        margin-top:1em;
    }
    .quote-table tr td,
    .quote-table tr th{
        vertical-align: top;
        padding: 7px 10px;
        background-color: #ffffff;
        border:3px solid #74be4b;
        border-bottom: 0;
        border-right: 0;
    }
    .quote-table tr td.empty-cell{
        background-color:#74be4b;
    }
    .quote-table tr th{
        background-color: #74be4b;
        font-size: 0.8em;
    }

    .quote-table tr td:last-child,
    .quote-table tr th:last-child{
        border-right:3px solid #74be4b;
    }
    .quote-table tr:last-child td{
        border-bottom:3px solid #74be4b;
    }
    
    .quote-table .quote-subtable{
        width:100%;
        border: 1px solid lightgray;
        background-color: white;
    }


    .quote-table tr th{
        vertical-align: top;
        text-align: left;
        font-weight: bold;
    }

    }
    .quote-table .label{
        width:33%;
        text-align:left;
    }

    .quote-table .label.middle{
        vertical-align:middle;
    }

    .quote-table .wide-field{
        width:66%;
        text-align:left;
    }
    .quote-table .unit-field{
        width:16.5%;
        text-align:left;
    }
    .quote-table .money,
    .quote-table .unit-field.money{
        text-align: right;
    }
    .quote-table .center,
    .quote-table .unit-field.center{
        text-align: center;
    }
    .quote-table tr.totals td{
        font-weight:bold;
        border-bottom: 4px solid #74be4b;
    }

    .quote-wrapper-table{
        width:{{$contentWidth}}px;
    }
    
    .quote-wrapper-table .terms td {
        padding:30px 10px 10px;
    }

    .quote-wrapper-table tr.yellow{
        background-color:#e1e34d ;
    }

    .quote-wrapper-table tr.grey{
        background-color:#e5e5e5;
    }
    .quote-wrapper-table .summary .notes-box{
        width:100%;
        height: 210px;
        border-bottom: 3px solid #74be4b;
    }
    .quote-wrapper-table .summary .empty-cell{

    }

    .actions-required-wrapper,
    .authorisation-wrapper{
        padding: 3px;
    }

    .actions-required-wrapper p,
    .authorisation-wrapper p {
        padding: 7px 9px 7px;
        margin:0;
    }
    .actions-required{
        background-color: #ffffff;
        padding: 7px 10px;
        width:100%;
    }
    .authorisation-table{
        width:100%;
    }
    .authorisation-table td,
    .authorisation-table th{
        vertical-align: top;
        padding: 7px 10px;
    }

    .authorisation-table .label{
        width:10%;
    }
    .authorisation-table .field{
        width:23%;
        background-color: #ffffff;
    }
    .header-table {
        width:100%;
        margin:0 0 10px;
    }
    .header-table td{
        width:50%;
        vertical-align: middle;
    }
    td.align-right{
        text-align: right;
    }
    .header-table td p{
        margin:0;
    }
    .quote-details-table{
        width:100%;
        margin-bottom: 10px;
    }
    .quote-details-table td{
        width:33%;
    }
    .installation-details-table {
                    width:100%;
    }
    .installation-details-table td{
        vertical-align: top;
        padding: 7px 10px;
        border: 3px solid #e5e5e5;
        border-bottom: 0;
        border-right: 0;
    }
    .installation-details-table tr td:last-child{
        border-right: 3px solid #e5e5e5;
    }
    .installation-details-table tr:last-child td{
        border-bottom: 3px solid #e5e5e5;
    }

    .installation-details-table .label {
        width: 18%;
    }
    .installation-details-table .field {
        width: 32%;
        background-color: #ffffff;
    }
    .installation-details-table .field.wide-field {
        width:80%;
    }
</style>

<table cellpadding="0" cellspacing="0" class="quote-wrapper-table">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" class="header-table">
                <tr>
                    <td>
                        <img src="images/logo-quote.jpg" width="270" height="120" />
                    </td>
                    <td class="align-right">
                        <p>ENERGYSMART <strong>0800 777 111</strong><br>
                        www.energysmart.co.nz</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" class="quote-details-table">
                <tr>
                    <td>
                        <h2 class="no-margin">Live Warm &middot; Live Smart</h2>
                    </td>
                    <td>Date: {{$quote_date}}</td>
                    <td class="align-right">
                        Quote Number: {{$quote_number}}
                    </td>
                </tr>
            </table>    
            
        <td>
    </tr>
    <tr class="grey">
        <td>
            <table cellpadding="0" cellspacing="0" class="installation-details-table">
                <tr>
                    <td class="label">Assessor</td>
                    <td class="field">{{$assessor_name}}</td>
                    <td class="label">Email</td>
                    <td class="field">{{$assessor_email}}</td>
                </tr>
                <tr>
                    <td class="label">Owner Name</td>
                    <td class="field">{{$owner_name}}</td>
                    <td class="label">Email</td>
                    <td class="field">{{$owner_email}}</td>
                </tr>
                <tr>
                    <td class="label">Property Address</td>
                    <td class="field wide-field" colspan="3">{{$property_address}}</td>
                </tr>
                <tr>
                    <td class="label">Postal Address</td>
                    <td class="field wide-field" colspan="3">{{$postal_address}}</td>
                </tr>
                <tr>
                    <td class="label">Owner Phone</td>
                    <td class="field wide-field" colspan="3">(Home/Work) {{$owner_telephone}} (Mobile) {{$owner_mobile_phone}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <h2 class="solution-heading">Our Recommended <span class="product-name">{{$solution}}</span> Solution</h2>     
            <table cellpadding="0" cellspacing="0" class="quote-table">
                <tr>
                    <th class="label">Product</th>
                    <th class="unit-field center">Quantity</th>
                    <th class="unit-field money">Unit/Price</th>
                    <th class="unit-field money">Total</th>
                    <th class="unit-field money">Discount</th>
                    <th class="unit-field money">To Pay</th>
                </tr>

<?php

foreach ($product_array as $prod) {
    echo '<tr>
        <td class="label">'.$prod['prod_name'].'</td>
        <td class="unit-field center">'.$prod['quantity'].'</td>
        <td class="unit-field money">'.$prod['unit_price'].'</td>
        <td class="unit-field money">'.$prod['total'].'</td>
        <td class="unit-field money">'.$prod['discount'].'</td>
        <td class="unit-field money">'.$prod['to_pay'].'</td>
      </tr>';
};


?>
                
                <tr class="totals">
                    <td class="label" colspan="3">Totals</td>
                    <td class="unit-field money">$000.00</td>
                    <td class="unit-field money">$000.00</td>
                    <td class="unit-field money">$000.00</td>
                </tr>
                <tr class="summary">
                    <td colspan="2" rowspan="3" class="notes-box">{{$quote_notes}}</td>
                    <td colspan="3" class="money">Deposit Required</td>
                    <td class="money">$000.00</td>
                </tr>
                <tr class="summary">
                    <td colspan="3" class="money">Final Payment Required within 7 days of Installation</td>
                    <td class="money">$000.00</td>
                </tr>
                <tr class="summary">
                    <td colspan="4"class="empty-cell">&nbsp;</td>
                </tr>
            </table>
            <p>PRODUCT BRAND IS SUBJECT TO ENERGYSMART&rsquo;S INSULATION PRODUCT SUBSTITUTION POLICY (refer to terms and conditions)</p>
        </td>
    </tr>
    <tr class="yellow">
        <td>
            <div class="actions-required-wrapper">
                <p>The following actions are the responsibility of the home owner and must be completed prior to installation</p>
                <div class="actions-required">No action noted on assessment.</div>
            </div>

        </td>
    </tr>
    <tr class="grey">
        <td>
            <div class="authorisation-wrapper">
                <p>Authorisation is given by your signature or by payment of deposit<br>
                <strong>Accepted by:</strong></p>
                <table cellpadding="0" cellspacing="0" class="authorisation-table">
                    <tr>
                        <td class="label"><strong>Name:</strong></td>
                        <td class="field">{{$owner_name}}</td>
                        <td class="label"><strong>Sign:</strong></td>
                        <td class="field"></td>
                        <td class="label"><strong>Date:</strong></td>
                        <td class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>





            <h2>Thank you for the opportunity to assess your home</h2>
            <p>Applicable EECA and 3rd party subsidies are subject to availability at time of installation and should that funding not be available for any reason then the contract/offer is null and void. Based on the information we have obtained from this assessment, EnergySmart is pleased to offer you this quote.</p>
            <p>The quotation is based either on the gross building area measured through and including framing OR on the quantity of Product stated which includes any waste as appropriate.</p>
            <ol class="ordered-list">
                <li>EnergySmart reserves the right to adjust the invoiced amount from the amount shown on the quote in the event that the quantity installed differs from the amount referred to in the quote.</li>
                <li>The homeowner will ensure a person over the age of 18 is home during installation.</li>
            </ol>
            <p>If you require any further information or assistance, pease feel free to call or email us. Whilst this quote has been prepared with care, we reserve the right to alter the final price if the measure or install requirements are revised on further inspection by our Auditors. This quote is valid for 21 days and subject to the Standard Conditions of Contract below.</p>
            <p><strong>Payment &amp; Finance</strong> To accept this quote, it must be signed and dated. Alternatively your deposit shall be deemed your full acceptance of the quote.</p>
            <ul class="unordered-list">
                <li>Internet Banking: ANZ 06 0821 0259765 05 and reference Quote number.</li>
                <li>Credit Card: Phone 0800 777 111 and speak to your local office.</li>
                <li>Cheque: Post to EnergySmart, P O Box 19755, Christchurch 8241.</li>
                <li>Finance: Please talk to your Assessor.</li>
            </ul>
            <h2>EnergySmart Limited Standard Conditions of Contract</h2>
            <ol class="ordered-list">
                <li>
                    <p><strong>DEFINITIONS:</strong><br>
                    <em>&ldquo;Customer&rdquo;</em> means the person(s) or company to whom the quotation is addressed.<br>
                    <em>&ldquo;Product&rdquo;</em> means material supplied and/or installed by EnergySmart or our Contractor.<br>
                    <em>&ldquo;Contractor&rdquo;</em> means any individual, partnership or company that is conducting services on behalf of and with the authority of EnergySmart.</p>
                </li>
                <li>
                    <p><strong>VALIDITY.</strong> Unless accepted in writing by the Customer prior to lapsing, the offer specified in the quotation shall lapse 21 calendar days after the date of the quotation and in any case may be withdrawn by EnergySmart at any time prior to receipt of written acceptance.</p>
                </li>
                <li>
                    <p><strong>ACCEPTANCE.</strong> Acceptance of the quotation by the Customer infers acceptance of the Standard Conditions of Contract unless expressly excluded and confirmed in writing. Work will not be commenced until acceptance has been confirmed in writing or the correct deposit is received.</p>
                </li>
                <li>
                    <p><strong>INSTALLATION ACCESS.</strong> access suitable for labour and Product is required to all roofs/ceilings and under floors to be insulated and rooms where Product is to be installed. Access is deemed suitable only when all storage, rubbish or debris are completely removed, and the working space fits EnergySmart&rsquo;s Health and Safety guidelines. The Customer is responsible for any scaffolding or other required platform unless specifically stated otherwise in the quote. Any time spend by EnergySmart or our Contractor providing suitable access, working space or platform may be charged to the Customer at prevailing rates.</p>
                </li>
                <li>
                    <p><strong>AUDITING.</strong> As a function of the Quality Assurance process EnergySmart requires access to audit the work of our installers. This may require access in addition to the installation time. By signing this quote, the customer is agreeing to have their house audited as required by EnergySmart.</p>
                </li>
                <li>
                    <p><strong>RESCHEDULING OF CONTRACT.</strong> Risk of loss, damage,deterioration or removal of any Product shall be borne by the Customer from the time of supply. Any remedial work to or replacement of such Product will only be carried out by EnergySmart on receipt of a written request or variation order and may be charged to the Customer at prevailing rates. EnergySmart takes no responsibility for cracking, warping, or shrinkage of flooring or other forms of damage that may arise due to altering of moisture levels as a result of installation of the insulation.</p>
                </li>
                <li>
                    <p><strong>TERMS OF PAYMENT.</strong> Unless specified otherwise in writing, payment for the full GST inclusive amount is required within 7 calendar days of contract completion. Where necessary, EnergySmart may instruct a third party to collect unpaid costs. All costs incurred in relation to collection of overdue accounts will be payable to the Customer and added to the Customer&rsquo;s account.</p>
                </li>
                <li>
                    <p><strong>PROPERTY.</strong> Ownership of the Product shall only pass to the Customer upon payment of the price in full.</p>
                </li>
                <li>
                    <p><strong>CLAIMS FOR CONSEQUENTIAL LOSS.</strong> Subject to any legislative provision otherwise, EnergySmart&rsquo;s liability is limited to replacement or repair of any defective Product subject to any claims having been made in writing by the Customer as soon as the Customer has become aware of such defective Product, nor for any event considered a force majeure which is beyond the direct control of EnergySmart or its Contractors.</p>
                </li>
                <li>
                    <p><strong>Insulation Product Substitution Policy.</strong> From time to time EnergySmart may at its discretion install a substitute product other than the one shown on the Quote. This policy only applies to insulation. The substitute product will at all times be of the same or higher thermal rating and:</p>
                    <ul class="unordered-list square"> 
                        <li>have a current BRANZ appraisal,</li>
                        <li>be approved for the government funded insulation program,</li>
                        <li>have a minimum of 50 years warranty,</li>
                        <li>where a product with no added formaldehyde has been quoted, use only product with no added formaldehyde,</li>
                        <li>be a product of the highest quality.</li>
                    </ul>
                    <p>The substitution policy allows EnergySmart to avoid stock shortage situations and allows us to continually procure high quality product at industry leading rates which in turn we pass on to our customers as a high value, high quality offering. If you wish your quotation to not be subject to product substitution policy, please inform EnergySmart in writing, prior to the quotation being accepted.</p>
                </li>
            </ol>
            <h2>EnergySmart Privacy Policy</h2>
            <p>EnergySmart has adopted this Privacy Policy to ensure that we handle personal information in accordance with the Privacy Act 1993.</p>
            <p><strong>Personal Information</strong> - EnergySmart collects, holds and uses personal customer information Customer information is usually collected by our assessment employees at the time we scoop your home for our products.<br>
            The information may include:</p>
            <ul class="unordered-list circle">
                <li>your name, address, contact number(s) and email address,</li>
                <li>information about your preference for goods or services we offer.</li>
            </ul>
            <p><strong>Purposes for collecting the information</strong> - We use customer information for the following purposes:</p>
            <ul class="unordered-list circle">
                <li>to contact you directly to arrange installation and follow up audits,</li>
                <li>to contact you directly about EnergySmarts, special offers, and other promotions,</li>
                <li>to promote the merit of our Insulation programs to gain funding for future programs.</li>
            </ul>
            <p><strong>How we manage personal information</strong> - EnergySmart is dedicated to keeping personal information secure. This includes physical security, computer and network security, communications security and personnel security.</p>
            <p><strong>Disclosure</strong> - EnergySmart does not sell, rent or otherwise make available any personal information to third parties. EnergySmart outsources certain business functions to other organisations. For this purpose, and only for the purpose of providing services to EnergySmart, customer contact information may, as required, be transferred to or handled by:</p>
            <ul class="unordered-list circle">
                <li>our related companies,</li>
                <li>credit reference agencies or other credit providers,</li>
                <li>government or statutory authorities.</li>
            </ul>
            <p><strong>Access and correction of details</strong> - You can access personal information EnergySmart holds on you by contacting the The Branch Manager in writing. If the information held is inaccurate, incomplete or not up to date you may request EnergySmart to correct the information.</p>
            <p><strong>Changes to the Privacy Policy</strong> - We may update this Privacy Policy from time to time.</p>


            <br>
            <br>

            <p class="copyright">Issued by EnergySmart a trading entity of Terra Lana Product Limited. [[QUOTE_DATE_MONTH]] [[QUOTE_DATE_YEAR]].</p>







<!-- end quote -->


</body>
</html>