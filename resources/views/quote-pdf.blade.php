<!DOCTYPE html>
<html>

<head>
  <title>ENS Quote</title>
  <!-- <link rel="stylesheet" href="index.css" /> -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400&display=swap"
    rel="stylesheet" />
  <style>
    @page {
      margin: 20px;
    }

    body {
      width: 700px;
      color: #010101;
      margin: 20px;
    }

    .parent-table {
      padding: 36px;
    }

    table,
    tr {
      width: 100%;
      /*max-width: calc(700px - 72px);*/
    }

    tr {
      width: 100%;
      min-width: 700px;
      max-width: 700px;
    }

    * {
      font-family: 'Lato', Arial, Helvetica, sans-serif;
      font-family: 'Lato', sans-serif;
      font-size: 11px;
    }

    p {
      line-height: 14px;
    }

    .standard-conditions-title {
      font-size: 14px;
      margin-bottom: 0px;
    }

    h4 {
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    li::marker {
      font-weight: 700;
    }

    li h4 {
      margin: 0;
      margin-top: 1px;
      line-height: 1;
    }

    h2 {
      font-size: 1.5em;
      margin: 0 0 20px;
      line-height: 120%;
    }

    p {
      margin: 0;
      margin-bottom: 14px;
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
      margin-bottom: 10px;
      line-height: 12px;
    }
    
    .assessment-details {
      font-weight: bold;
    }

    .legal-details-pg1 p,
    .legal-details-pg2 p {
      font-size: 11px;
      line-height: 110%;
    }

    .legal-details-pg1,
    .legal-details-pg2 {
      break-before: always;
    }

    .legal-details-pg1 li,
    .legal-details-pg2 li {
      margin: 0;
    }

    .right-hand-column h4:first-of-type {
      margin-top: 0px;
    }

    .installation-details-table td,
    .table-wrapper td {
      vertical-align: top;
      padding: 6px 10px;
    }

    .quote-table tr td,
    .quote-table tr th {
      vertical-align: top;
      padding: 6px 8px;
    }

    .quote-table .unit-field {
      max-width: 60px;
      min-width: 60px;
      width: 60px;
      overflow: hidden;
      text-align: left;
    }

    .quote-table .money.deposit-required {
      color: #a83232;
    }

    .quote-wrapper-table,
    .table-wrapper {
      width: 100%;
      /*max-width: 700px;*/
    }

    td.align-right {
      text-align: right;
    }

    .installation-details-table {
      width: 100%;
    }

    html {
      background: #dae0e7;
    }

    table {
      background: #ffffff;
    }

    .spacer {
      height: 20px;
      width: 100%;
    }

    .half-spacer {
      height: 6px;
      width: 100%;
    }

    .page-seperator {
      border-top: 1px solid #4c4c53;
    }

    .legal-details-title {
      color: #2f893c;
      font-size: 16px;
      line-height: 16px;
      font-weight: 900;
      margin-bottom: 0px;
    }

    .label-column {
      width: 96px;
    }

    .small-label-column {
      width: 80px;
    }

    .section-heading {
      font-weight: bold;
      font-size: 12px;
    }

    .italic {
      font-style: italic;
    }

    .bold {
      font-weight: 700;
    }

    .heavy {
      font-weight: 900;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .input--bg,
    .field {
      background-color: #efefef;
    }

    .table-title-bar--colour {
      background-color: #75bd4b;
      color: #ffffff;
      font-weight: 900;
    }

    th.quote-breakdown-product-column {
      font-weight: 900;
    }

    .sig-acceptance-box {
      background-color: #d9ebcd;
    }

    .sig-acceptance-row__size>.sig-label:first-of-type {
      width: 12ch;
    }

    .sig-acceptance-row__size td {
      border: 10px solid #d9ebcd;
    }

    .sig-label {
      width: 4ch;
    }

    .sig-input {
      width: 96px;
    }

    .sig-input {
      background-color: #ffffff;
    }

    .table-wrapper td.sig-label {
      padding-right: 4px;
    }

    .table-wrapper td.sig-label:first-of-type {
      padding-left: 0px;
    }

    .zebra-tr:nth-child(even):not(:first-child):not(:last-child) {
      background-color: #d9ebcd;
    }

    .zebra-tr.totals {
      background-color: #75bd4b;
      color: #010101;
    }
    .zebra-tr.totals td{
      border-bottom: 1px solid #d9ebcd;
    }

    .zebra-even {
    }

    .zebra-odd {
      background-color: #d9ebcd;
    }

    .quote-breakdown-product-column {
      width: 200px;
    }

    .contract-title {
      width: 100%;
      width: 700px;
    }

    .half-width-column {
      width: 50%;
      /*max-width: calc(700px - 72px);*/
    }

    .table-wrapper {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .custom-info-rows__spacing {
      /*border-bottom: 8px solid #ffffff;*/
    }

    .actions-required-row {
      border-top: 12px solid #ffffff;
    }

    .actions-group--layout {
      margin: 10px 6px;
    }

    .actions-required {
      padding: 6px 10px 0px 0px;
    }

    .required-actions-output__layout {
      background: #ffffff;
      padding: 12px 10px;
      height: fit-content;
    }

    .required-actions--text {
      color: #010101;
      line-height: 140%;
      margin-bottom: 0px;
    }

    .remove-padding>td,
    .remove-padding>tr,
    .remove-padding {
      padding: 0px;
    }



    .nested-payment-table tr td:not(.payment-values) {
      padding-left: 0px;
      padding: 10px 10px 10px 0px;
    }

    .payment-terms-text__style {
      font-style: italic;
      font-size: 10px;
    }

    .payment-breakdown--title {
      margin: 0px;
      padding-bottom: 16px;
      margin-bottom: 8px;
      font-size: 14px;
      border-bottom: 2px solid #b2b2b8;
      width:100%;
    }

    .payment-breakdown-border>td {
      border-top: 6px solid #ffffff;
    }

    .quote-date {
      margin-top: 10px;
      padding: 6px 10px;
      background-color: #ffffff;
    }

    .payment-details-columns-1 {
      width: 58%;
    }

    .payment-details-columns-2 {
      width: 42%;
    }

  </style>
</head>

<body>
  <table class="quote-wrapper-table parent-table">
    <tr class="header">
      <td>
        <table class="header-table">
          <tr>
            <td>
              <img alt="EnergySmart Logo" src="images/energysmart-logo.png" width="200" height="96" />
            </td>
            <td class="align-right">
              <p>
                <span class="bold">ENERGYSMART | 0800 777 111</span>
                <br />
                www.energysmart.co.nz
                <br />
                <br />
                <br />
                Date: {{$quote_date}}
                <br />
                <span class="italic">Quote Number: {{$quote_number}}</span>
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="assessment-detail">
      <td>
        <table class="installation-details-table table-wrapper">
          <!-- Assessor info -->
          <tr>
            <td class="heavy label-column">Assessor</td>
            <td class="label label-column">Assessor Name</td>
            <td class="field">{{$assessor_name}}</td>
            <td class="label small-label-column">Email</td>
            <td class="field">{{$assessor_email}}</td>
          </tr>
          <tr class="spacer">
            <td colspan="5"></td>
          </tr>
          <!-- Owner and address details -->
          <tr class="custom-info-rows__spacing">
            <td class="heavy label-column">Owner</td>
            <td class="label label-column">Name</td>
            <td class="field wide-field" colspan="3">{{$owner_name}}</td>
          </tr>
          <tr class="half-spacer"><td colspan="5"></td></tr>
          <tr class="custom-info-rows__spacing">
            <td></td>
            <td class="label label-column">Property Address</td>
            <td class="field wide-field" colspan="3">
              {{$property_address}}
            </td>
          </tr>
          <tr class="half-spacer"><td colspan="5"></td></tr>
          <tr class="custom-info-rows__spacing">
            <td></td>
            <td class="label label-column">Postal Address</td>
            <td class="field wide-field" colspan="3">{{$postal_address}}</td>
          </tr>
          <tr class="half-spacer"><td colspan="5"></td></tr>
          <tr class="custom-info-rows__spacing">
            <td></td>
            <td class="label label-column">Owner Phone</td>
            <td class="field">{{$owner_telephone}}</td>
            <td class="label small-label-column">Owner Mobile</td>
            <td class="field">
              @if($owner_mobile_phone != "Not set")
                {{$owner_mobile_phone}}
              @endif
            </td>
          </tr>
          <!-- Tenant details -->
          <tr class="spacer">
            <td colspan="5"></td>
          </tr>
          <tr class="custom-info-rows__spacing">
            <td class="heavy label-column">Tenant Details</td>
            <td class="label label-column">Tenant Name</td>
            <td class="field" colspan="3">{{$occupier_name}}</td>
          </tr>
          <tr class="half-spacer"><td colspan="5"></td></tr>
          <tr>
            <td></td>
            <td class="label label-column">Tenant Phone</td>
            <td class="field">{{$occupier_phone}}</td>
            <td class="label small-label-column">Tenant Mobile</td>
            <td class="field">{{$occupier_mobile}}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="spacer">
      <td></td>
    </tr>
    <tr class="quote-breakdown">
      <td>
        <table class="quote-table table-wrapper" style="width: 100%">
          <tr class="table-title-bar--colour" style="width: 100%">
            <th class="label quote-breakdown-product-column">Product</th>
            <th style="text-align:center;">Quantity</th>
            <th style="text-align:right;">Unit RRP</th>
            <th style="text-align:right;">Unit Price</th>
            <th style="text-align:right;">Discount</th>
            <th style="text-align:right;">To Pay</th>
          </tr>
          @foreach ($product_array as $product)
            <tr class="{{$loop->even ? 'zebra-even' : 'zebra-odd'}}">
              <td class="quote-breakdown-product-column">{{ $product['prod_name'] }}</td>
              <td style="text-align:center;">{{ $product['quantity'] }}</td>
              <td style="text-align:right;">{{ $product['rrp'] }}</td>
              <td style="text-align:right;">{{ $product['unit_price'] }}</td>
              <td style="text-align:right;">{{ $product['discount'] }}</td>
              <td style="text-align:right;">{{ $product['to_pay'] }}</td>
            </tr>
          @endforeach

          <!-- QUOTE TOTALS -->
          <tr class="totals heavy zebra-tr">
            <td class="label quote-breakdown-product-column" colspan="5">Total Quote Price</td>
            <td style="text-align:right;">{{ $totals_to_pay }}</td>
          </tr>

          @if($totals_eeca_contribution != "$0.00" && $totals_eeca_contribution != "Not set")
          <tr class="totals heavy zebra-tr">
            <td class="label quote-breakdown-product-column" colspan="5">EECA Contribution
              @if($assessment_type == "Heat Pump")
                &nbsp;(Up to $3,000)
              @endif
            </td>
            <td style="text-align:right;">{{ $totals_eeca_contribution }}</td>
          </tr>
          @endif

          @if($totals_tpf_provider != "" && $totals_tpf_provider != "Not set")
          <tr class="totals heavy zebra-tr">
            <td class="label quote-breakdown-product-column" colspan="5">Third Party Funding: {{ $totals_tpf_provider }}</td>
            <td style="text-align:right;">{{ $totals_tpf }}</td>
          </tr>
          @endif
  

          <tr class="totals heavy zebra-tr">
            <td class="label quote-breakdown-product-column" colspan="5">Owners Contribution</td>
            <td style="text-align:right;">{{ $totals_owners_contribution }}</td>
          </tr>

        </table>
        <!-- <p>PRODUCT BRAND IS SUBJECT TO ENERGYSMART&rsquo;S INSULATION PRODUCT SUBSTITUTION POLICY (refer to terms and conditions)</p> -->
      </td>
    </tr>
    <tr class="half-spacer">
      <td></td>
    </tr>

    <tr class="payment-breakdown-row remove-padding">
      <td>
        <table class="table-wrapper" style="width:100%">
          <tr>
            <td colspan="2"><h4 class="payment-breakdown--title uppercase heavy">Payment</h4></td>
          </tr>
          <tr class="payment-breakdown-border">
            <td class="payment-label-column bold">Deposit Required</td>
            <td class="input--bg payment-values deposit-width" style="text-align:right;">{{$deposit_required}}</td>
          </tr>
          <tr class="payment-breakdown-border">
            <td class="payment-label-column bold">Final Payment Required within 7 days of Installation</td>
            <td class="input--bg payment-values" style="text-align:right;">{{$balance_remaining}}</td>
          </tr>
          <tr class="payment-breakdown-border">
            <td class="payment-label-column bold">Preferred Payment Option</td>
            <td class="input--bg payment-values">
              @if($preferred_payment_option != "Not set")
                {{$preferred_payment_option}}
              @endif  
            </td>
          </tr>
          <tr class="payment-breakdown-border">
            <td class="payment-label-column bold">Contact for Access</td>
            <td class="input--bg payment-values">{{$contact_for_access}}</td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="spacer">
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td class="payment-terms-text__style">
      @if($assessment_type == "Heat Pump")
        Product brand is subject to EnergySmart's Heat Pump Product substitution policy (refer to terms and conditions)*
      @else
        Product brand is subject to EnergySmart's Insulation Product substitution policy (refer to terms and conditions)*
      @endif
      </td>
    </tr>

    <tr>
      <td class="payment-terms-text__style">
        <span class="bold">Payment options:</span> Direct debit, credit card, Qmastercard (interest free options available and mortgage tops ups).
      </td>
    </tr>

    @if($quote_notes && $quote_notes != "Not set")
      <tr>
        <td class="payment-terms-text__style">
          <span class="bold">Note:</span> {{ $quote_notes }}
        </td>
      </tr>
      @endif
    <tr class="spacer">
      <td> </td>
    </tr>

    <tr class="payment-breakdown-row">
      <td class="remove-padding">
        <table class="table-wrapper" style="width:100%">
          <tr class="actions-required-row">
            <td class="table-title-bar--colour actions--layout">
              <div class="actions-group--layout">
                <p class="bold">
                  The following actions are the responsibility of the
                  homeowner and must be completed prior to installation:
                </p>
                <div class="
                      required-actions-output__layout
                      required-actions--text
                      italic
                    " style="background-color: #ffffff; padding: 12px 10px; color: #010101; font-style: italic; font-weight: normal;">
                
                    <ul>
                    @foreach ($actions_required_array as $a_req)
                      <li>{{ $a_req }}</li>
                    @endforeach
                    </ul>
                    @if($assessment_type == "Heat Pump")
                      @if(count($actions_required_array) == 0)
                        None
                      @endif
                    @else
                      There may be a variance of ceiling insulation installed due to any existing insulation, unused metres will be taken off the balance.
                    @endif
                </div>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="spacer">
      <td></td>
    </tr>
    <tr>
      <td>
        <table class="sig-acceptance-box table-wrapper" style="width: 100%;">
          <tr class="sig-acceptance-row__size">
            <td class="bold sig-label">Accepted by</td>
            <td class="bold sig-label">Name:</td>
            <td class="sig-input">{{$owner_name}}</td>
            <td class="bold sig-label">Sign:</td>
            <td class="sig-input">
              @if($signature)
                <img src="{{$signature}}" alt="" style="max-width: 96px;">
              @endif
            </td>
            <td class="bold sig-label">Date:</td>
            <td class="sig-input">
              {{$date_signed ?? ""}}
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="spacer">
      <td></td>
    </tr>
    <tr class="legal-details-pg1">
      <td>
        <table class="table-wrapper page-seperator" style="table-layout: fixed;">
          <tr>
            <td colspan="2">
              <h3 class="legal-details-title">
                Thank you for the opportunity to assess your home.
              </h3>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              Based on the information we have obtained from this assessment,
              EnergySmart is pleased to offer you this quote
              <span class="italic">
                Authorisation is given by your signature or by payment of
                deposit
              </span>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <h3 class="standard-conditions-title">
                EnergySmart Standard Conditions of Contract
              </h3>
            </td>
          </tr>
          <tr>
            <td style="width: 50%">
              <p>
                The quotation is based either on the gross building area
                measured through and including framing OR on the quantity of
                Product stated which includes any waste as appropriate.
              </p>
              <ol>
                <li>
                  EnergySmart reserves the right to adjust the invoiced amount
                  from the amount shown on the quote in the event that the
                  quantity installed differs from the amount referred to in
                  the quote
                </li>
                <li>
                  The homeowner will ensure a person over the age of 18 is
                  home during installation
                </li>
              </ol>
              <p>
                If you require any further information or assistance, pease
                feel free to call or email us. Whilst this quote has been
                prepared with care, we reserve the right to alter the final
                price if the measure or install requirements are revised on
                further inspection by our Auditors. This quote is valid for 21
                days and subject to the Standard Conditions of Contract below.
              </p>
              <p>
                Payment and finance: To accept this quote, it must be signed
                and dated. Alternatively your deposit shall be deemed your
                full acceptance of the quote.
              </p>
              <ul>
                <li>
                  Internet Banking: ANZ 06 0821 0259765 05 and reference quote
                  number.
                </li>
                <li>
                  Credit Card: Phone 0800 777 111 and speak to your local
                  office.
                </li>
                <li>Finance: Please talk to your Assessor</li>
              </ul>
              <ol>
                <li>
                  <h4>Definitions</h4>
                  <p>
                    “Customer” means the person(s) or company to whom the
                    quotation is addressed. “Product” means material supplied
                    and/or installed by EnergySmart or our Contractor.
                    “Contractor” means any individual, partnership or company
                    that is conducting services on behalf of and with the
                    authority of EnergySmart
                  </p>
                </li>
                <li>
                  <h4>Validity</h4>
                  <p>
                    Unless accepted in writing by the Customer prior to
                    lapsing, the offer specified in the quotation shall lapse
                    21 calendar days after the date of the quotation and in
                    any case may be withdrawn by EnergySmart at any time prior
                    to receipt of written acceptance.
                  </p>
                </li>
                <li>
                  <h4>Acceptance</h4>
                  <p>
                    Acceptance of the quotation by the Customer infers
                    acceptance of the Standard Conditions of Contract unless
                    expressly excluded and confirmed in writing. Work will not
                    be commenced until acceptance has been confirmed in
                    writing or the correct deposit is received.
                  </p>
                </li>
              </ol>
            </td>
            <td class="right-hand-column" style="width: 50%;">
              <ol start="4">
                <li>
                  <h4>Installation access</h4>
                  <p>
                    Access suitable for labour and Product is required to all
                    roofs/ceilings and underfloors to be insulated and rooms
                    where Product is to be installed. Access is deemed
                    suitable only when all storage, rubbish or debris are
                    completely removed, and the working space fits
                    EnergySmart’s Health and Safety guidelines. The Customer
                    is responsible for any scaffolding or other required
                    platform unless specifically stated otherwise in the
                    quote. Any time spent by EnergySmart or our Contractor
                    providing suitable access, working space or platform may
                    be charged to the Customer at prevailing rates.
                  </p>
                </li>
                <li>
                  <h4>Auditing</h4>
                  <p>
                    As a function of the Quality Assurance process EnergySmart
                    requires access to audit the work of our installers. This
                    may require access in addition to the installation time.
                    By signing this quote, the customer is agreeing to have
                    their house audited as required by EnergySmart.
                  </p>
                </li>
                <li>
                  <h4>Rescheduling of contract</h4>
                  <p>
                    Risk of loss, damage, deterioration or removal of any
                    Product shall be borne by the Customer from the time of
                    supply. Any remedial work to or replacement of such
                    Product will only be carried out by EnergySmart on receipt
                    of a written request or variation order, and may be
                    charged to the Customer at prevailing rates. EnergySmart
                    takes no responsibility for cracking, warping, or
                    shrinkage of flooring or other forms of damage that may
                    arise due to altering of moisture levels as a result of
                    installation of the insulation.
                  </p>
                </li>
                <li>
                  <h4>Terms of payment</h4>
                  <p>
                    Unless specified otherwise in writing, payment for the
                    full GST inclusive amount is required within 7 calendar
                    days of contract completion. Where necessary, EnergySmart
                    may instruct a third party to collect unpaid costs. All
                    costs incurred in relation to collection of overdue
                    accounts will be payable to the Customer and added to the
                    Customer’s account.
                  </p>
                </li>
                <li>
                  <h4>Property</h4>
                  <p>
                    Ownership of the Product shall only pass to the Customer
                    upon payment of the price in full.
                  </p>
                </li>
                <li>
                  <h4>Claims for consequential loss</h4>
                  <p>
                    Subject to any legislative provision otherwise,
                    EnergySmart’s liability is limited to replacement or
                    repair of any defective Product subject to any claims
                    having been made in writing by the Customer as soon as the
                    Customer has become aware of such defective Product, nor
                    for any event considered a force majeure which is beyond
                    the direct control of EnergySmart or its Contractors.
                  </p>
                </li>
              </ol>
            </td>
          </tr>
          <tr class="spacer">
            <td colspan="2"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="legal-details-pg2">
      <td>
        <table class="table-wrapper page-seperator" style="table-layout: fixed;">
          <tr>
            <td colspan="2">
              <h3 class="standard-conditions-title">
                EnergySmart Privacy Policy
              </h3>
            </td>
          </tr>
          <tr>
            <td style="width: 50%;">
              <p>
                EnergySmart has adopted this Privacy Policy to ensure that we
                handle personal information in accordance with the Privacy Act
                2020.
                <br />
                <span class="bold">Personal Information</span>
                <br />
                EnergySmart collects, holds and uses personal customer
                information. Customer information is usually collected from
                you when you send us an enquiry, subscribe to our newsletter
                or by our assessment employees at the time we scope your home
                for insulation.
              </p>
              <div>
                <p>
                  We collect personal information from you, including
                  information about your:
                </p>
                <ul>
                  <li>
                    Your name, address, contact number(s) and email address
                  </li>
                  <li>Location</li>
                  <li>Computer or network</li>
                  <li>Interactions with us</li>
                  <li>Billing or purchase information</li>
                  <li>
                    Information about your preference for goods or services we
                    offer
                  </li>
                  <li>Age demographics of occupants per home</li>
                  <li>Recent information on usage of health services</li>
                  <li>Information about your property</li>
                  <li>
                    Information about how the websites are used (for example,
                    traffic volumes, time spent on pages, traffic source)
                  </li>
                  <li>
                    Your IP address and/or other device identifying data
                  </li>
                  <li>
                    Other information that you may disclose to us during our
                    relationship with you
                  </li>
                </ul>
              </div>

              <p>
                You are under no obligation to provide us with any such
                information. However, if you choose to withhold requested
                information, we may not be able to provide you with our
                services.
              </p>

              <div>
                <h4>Purposes for collecting the information</h4>
                <p>We collect your personal information in order to:</p>
                <ul>
                  <li>
                    Contact you directly to arrange installation and follow up
                    audits
                  </li>
                  <li>
                    Contact you directly about EnergySmarts’ special offers,
                    and other promotions
                  </li>
                  <li>
                    Promote the merit of our Insulation programs to gain
                    funding for future programs
                  </li>
                  <li>Report to the funders of the current program</li>
                  <li>Answer your query</li>
                  <li>Consider hiring you</li>
                  <li>Reach out to obtain feedback about our services</li>
                  <li>
                    Identify potential customers who wish to use our services
                  </li>
                </ul>
              </div>

              <div>
                <h4>How we manage personal information</h4>
                <p>
                  EnergySmart is dedicated to keeping personal information
                  secure. This includes physical security, computer and
                  network security, communications security and personnel
                  security.
                </p>
              </div>
            </td>
            <td style="width: 50%;">
              <p>
                Age demographics and health service information is held in a
                separate secure database where we do not capture customer
                information; name, address or contact details. When
                EnergySmart report to funders and promote to potential future
                funders the information provided to such parties contains no
                details of customer’s name, address or contact details.
              </p>
              <div>
                <h4>Use of cookies</h4>
                <p>
                  This website uses Google Analytics to help analyse how
                  visitors use this site. Google Analytics uses “cookies”,
                  which are small text files placed on your computer, to
                  collect standard internet log information and visitor
                  behaviour information in an anonymous form.
                </p>
              </div>
              <div>
                <h4>Remarketing</h4>
                <p>
                  This website uses remarketing service to advertise on third
                  party websites (including Google) to previous visitors to
                  our site. This could be in the form of an advertisement on
                  the Google search results page, or a site in the Google
                  Display Network. Third-party vendors, including Google, use
                  cookies to serve ads based on someone’s past visits to our
                  website. Any data collected will be used in accordance with
                  our own privacy policy and Google’s privacy policy.
                </p>
              </div>
              <div>
                <h4>Disclosure</h4>
                <p>
                  EnergySmart does not sell, rent or otherwise make available
                  any personal information to third parties. EnergySmart
                  outsources certain business functions to other
                  organisations. For this purpose, and only for the purpose of
                  providing services to EnergySmart, customer contact
                  information may, as required, be transferred to or handled
                  by:
                </p>
                <ul>
                  <li>Our related companies</li>
                  <li>Credit reference agencies or other credit providers</li>
                  <li>Government or statutory authorities.</li>
                </ul>
              </div>
              <div>
                <h4>Access and correction of details</h4>
                <p>
                  You can access personal information EnergySmart holds on you
                  by contacting the The Branch Manager in writing. If the
                  information held is inaccurate, incomplete or not up to date
                  you may request EnergySmart to correct the information.
                </p>
              </div>
              <div>
                <h4>Changes to the Privacy Policy</h4>
                <p>
                  We may update this Privacy Policy from time to time. You
                  have the right to ask for a copy of any personal information
                  we hold about you, and to ask for it to be corrected if you
                  think it is wrong. If you’d like to ask for a copy of your
                  information, or to have it corrected, please contact us at
                  <a href="mailto:support@energysmart.co.nz">
                    support@energysmart.co.nz
                  </a>
                  , or
                  <span class="bold">0800 777 111</span>
                  , or
                  <span class="italic">
                    55 Francella Street, Bromley, Christchurch, 8062.
                  </span>
                </p>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!-- end quote -->
  </table>
</body>

</html>