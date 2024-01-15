<!DOCTYPE html>

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">

   

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">

    @yield('meta')

    
   <!-- Favicon -->

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   

   <!-- CSS Files -->
   <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
   <link rel="stylesheet" href="{{ static_asset('assets/css/custom-style.css?v=') }}{{ now()->timestamp }}">
   <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


   @yield('style')
   <script>
       var AIZ = AIZ || {};
       AIZ.local = {
           nothing_selected: '{!! translate('Nothing selected', null, true) !!}',
           nothing_found: '{!! translate('Nothing found', null, true) !!}',
           choose_file: '{{ translate('Choose file') }}',
           file_selected: '{{ translate('File selected') }}',
           files_selected: '{{ translate('Files selected') }}',
           add_more_files: '{{ translate('Add more files') }}',
           adding_more_files: '{{ translate('Adding more files') }}',
           drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
           browse: '{{ translate('Browse') }}',
           upload_complete: '{{ translate('Upload complete') }}',
           upload_paused: '{{ translate('Upload paused') }}',
           resume_upload: '{{ translate('Resume upload') }}',
           pause_upload: '{{ translate('Pause upload') }}',
           retry_upload: '{{ translate('Retry upload') }}',
           cancel_upload: '{{ translate('Cancel upload') }}',
           uploading: '{{ translate('Uploading') }}',
           processing: '{{ translate('Processing') }}',
           complete: '{{ translate('Complete') }}',
           file: '{{ translate('File') }}',
           files: '{{ translate('Files') }}',
           upload_maximum_five_files: '{{ translate('You can only upload a maximum of 10 files.') }}',
       }
   </script>
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;600;700&display=swap');
   </style>


<style>
    .description_shop
    {
        display: block;
        max-width: 806px;
        word-wrap: break-word;
        height: auto;
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        margin-bottom: 1.5rem;
    }
    .comming_soon
    {
        width: 100%;
        display: flex;
        text-align: center;
        margin-top: 90px;
        flex-direction: column;
    }
    .text_comming_soon
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 72px;
        font-weight: 700;
        line-height: 78px;
        letter-spacing: -0.0004em;
        text-align: center;
        color: #333333;
        margin-bottom: 22px;
    }
    .sub_text_comming_soon
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
        letter-spacing: 0em;
        text-align: center;
        color: #797979;
        margin-bottom: 42px;
    }
    .num_of_product
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 16px!important;
        font-weight: 700!important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25 !important;
    }
    .icon_header
    {
        width: 26px;
        /* height: 26px; */
        font-size: 26px;
        /* display: flex !important; */
    }
    .text_order_finished
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 40px !important;
        font-weight: 700 !important;
        line-height: 48px;
        letter-spacing: -0.0004em;
    }
    .sub_text_order_finished {
        font-family: 'Roboto',sans-serif !important;
        font-size: 18px !important;
        font-weight: 400 !important;
        line-height: 26px;
        letter-spacing: 0em;
    }
    .return_to_shop
    {
        width: 250px;
        height: 50px;
        border-radius: 4px;
        color: #2E7F25;
        border: 1px solid #2E7F25;
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: center;
    }
    .row_box_img_brand
    {
        display: flex !important;
        justify-content: space-evenly !important;
    }
    .box_img_brand
    {
        max-width: 120px !important;
    }
    .brand_img
    {
        max-width: 100%;
        height: 90px !important;
        width: 90px !important;
    }
    .gallery
    {
        width: 100%;
        /* max-width: 1200px !important;   */
    }
    .active_choose_cate span
    {
        text-decoration: underline;
    }
    li:hover{
        cursor:default;
    }
    .form_left_side
    {
        display: flex !important;
        flex-direction: row;
        align-items: flex-start;
    }
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
    .radio_button_checkout
    {
        width: 18px;
        height: 18px;
    }
    .add_new_address
    {
        width: 162px;
        height: 50px;
        border-radius: 4px;
        color: #2E7F25;
        border: 1px solid #2E7F25;
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: center;

    }
    .select_payment_option
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;

    }
    .text_method
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        line-height: 35px;
        letter-spacing: -0.0004em;
        text-align: left;
    }
    .text_trans
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 12px;
        font-weight: 700;
        line-height: 28px;
        letter-spacing: 0.25px;
        text-align: left;
        color: #333333;
    }
    .price_shipping
    {
        font-family:  'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 18px;
        letter-spacing: 0em;
        text-align: left;
        color: #589951;
    }
    .home-slider {
        max-width: calc(100% - 270px) !important;
    }
    .manual_payment_description
    {
        /* font-family: Roboto;
        font-size: 14px;
        font-weight: 700;
        line-height: 18px;
        letter-spacing: -0.0004em;
        text-align: left; */

        font-family:  'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        line-height: 18px;
        letter-spacing: -0.0004em;
        text-align: left;
        color:  #797979;
    }
    .delivery_type
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        line-height: 24px;
        letter-spacing: 0em;
        text-align: left;
        color:#797979;
        margin-left: 13px;
    }
    .quantity_product
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        line-height: 35px;
        letter-spacing: -0.0004em;
        text-align: left;

    }
    .header_table
    {
        background-color: #F5F5F5;
        height: 58px;
        display: flex;
        align-items: center;
    }
    .header_checkout_div
    {
        height: 92px;
        border-bottom  :1px  solid;
        border-color: #ededf2 !important;
        margin-bottom: 2rem;
    }
    .header_checkout
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 40px;
        font-weight: 700;
        line-height: 48px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25;
    }
    .shipping_info
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
        margin-left: 8px;
    }
    .payment_option
    {
        border-right: 0px !important;
        border-bottom: 0px !important;
        border-left: 0px !important;
    }
    .price_product_cart_details
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color:#B6B6B6;

    }
    .pt-site-footer__submit{
        display: inline-block;
        position: relative;
        overflow: hidden;   
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        width: 220px;
        height: 50px;
    }
    .final_price
    {
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: right;
        color: #2E7F25;
    }
    .coupon_code {
        background: #FFFFFF;
        border: 0;
        border-radius: 10px;
        /* color: white; */
        padding: 20px;
        /* min-width: 320px; */
        height: 100%;
        width: 100%;
    }

    .button_coupon {
        position: absolute;
        background: #2E7F25;
        border: 0;
        border-radius: 7px;
        color: white;
        padding: 15px;
        cursor:pointer;
        right: 0px;
        height: 100%;
        top: 50%;
        transform: translate(0, -50%);
    }
    .first_data_description
    {
        display: flex;
        height: 158px;
        margin-bottom: 1rem;
        flex-direction: column;
        justify-content: space-between;
    }
    .head_description
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        line-height: 32px !important; 
        letter-spacing: -0.0004em !important; 
        text-align: left !important;
        color: #333333 !important; 

    }
    .span_for_description
    {
        width: 1200px;
    }
    .div_for_description
    {
        margin-bottom: 1rem;
    }
    .text_details_product
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px;
        font-weight: 700;
        line-height: 15px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25;
    }
    .data_group_category
    {
        max-width: 380px !important;
        /* border-radius: 10px;
        border: 1px solid #E5E5E5 ;  */
    }
    .all_category
    {
        max-width: 1200px !important;
        height: auto;
        display: flex;
        flex-wrap: wrap;
    }
    .group_category
    {
        width: 33.333%;
    }
    .group_category:nth-child(3n+1) {
        padding-right: 15px;
    }
    .group_category:nth-child(3n+2) {
        padding-left: 15px;
        padding-right: 15px;
    }
    .group_category:nth-child(3n) {
        padding-left: 15px;
    }
    .img_for_each_category
    {
        /* max-width: 280px !important; */
        height: 253px;
        border-radius: 10px;
        border: 1px solid #E5E5E5 ; 
        width: 100%;
    }
    .tex_for_each_category
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: 0em;
        text-align: left;
        color: #333333;
        margin-top: 20px;
        margin-bottom: 48px;
    }
    .text_head_categories
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 40px!important;
        font-weight: 700!important;
        line-height: 48px!important;
        letter-spacing: -0.0004em;
        text-align: left;
        color:#2E7F25 !important;
    }
    .firts_description
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px !important;;
        font-weight: 400 !important;;
        line-height: 24px !important;;
        letter-spacing: 0em !important;;
        text-align: left !important;;

    }
    .unit_product
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 20px;
        font-weight: 700;
        line-height: 35px;
        letter-spacing: -0.0004em;
        text-align: left;
    }
    .total_product
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25 !important;
    }
    .text_cart_details
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color:#333333 !important;
    }
    .text_filter
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px;
        font-weight: 700;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;

    }
    .text_product_listing
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        line-height: 14px;
        letter-spacing: 0em;
        text-align: left;

    }
    .min_price
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25 !important;
    }
    .text_product_listing_sub
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        line-height: 14px;
        letter-spacing: 0em;
        text-align: left;
        color: #8d8d8d;
    }
    .img_sub_footer
    {
        width: 90px;
        height: 90px;
        margin: auto 0px;
        display: flex;
        align-items: center;
    }
    .sub_footer
    {
        display: flex;
        background-color: #F9F8F8;
        height: 220px;
        align-items: center;
        justify-content: space-evenly;
    }
    .sub_footer_mobile
    {
        display: none;
    }
    .slick-slider .slick-list, .slick-slider .slick-track
    {
        border-radius: 10px;
    }
    .top_selling_homepage
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 32px !important ; 
        font-weight: 700 !important;
        line-height: 40px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25;
    }
    @media (max-width: 1200px) {
        .parent_text_filter
        {
            justify-content: space-around !important;
        }
        .px-4
        {
            padding-left: unset !important;   
        }
        .top_selling_homepage
        {
            font-family: 'Quicksand',sans-serif !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            line-height: 40px !important;
            letter-spacing: -0.0004em;
            text-align: left;
            color: #2E7F25;
        }
        .home-slider {
            max-width: 100% !important;
        }
    }
    
    .text_for_img_head
    {
        width: 490px;
        font-family: 'Quicksand',sans-serif !important;
        font-size: 72px;
        font-weight: 700;
        line-height: 78px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #FFFFFF;
        z-index: 1;
        position: absolute;
        top: 149px;
        left: 305px;
        /* background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%); */
    }
    .clear_cart_text
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 20px !important;
        letter-spacing: -0.0004em;
        color: #797979 !important;
    }
    .text_name_product
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        width: 115px;
        word-wrap: break-word;
        height: auto;
    }
    .new_product_section_v2
    {
        display: flex;
        /* justify-content: space-between; */
        padding-left: unset !important;
        padding-right: unset !important;
        flex-wrap: wrap;
    }
    .sub_top_selling_v2
    {
        max-width: 273px !important;
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        transition: color 0.5s;
        z-index: 0;
        height: 100%;
    }
    .top_selling_v2
    {
        height: auto;
        width: 33.3%;
        /* max-width: 273px !important; */
        padding-right: 20px;
        /* padding-left: 10px; */
        margin-bottom: 2rem;
    }
    .top_selling_v2:nth-child(3n-3) {
        padding-right: 0px !important;
    }
    /* .top_selling_v2:nth-child(3n+1) {
        padding-left: 0px !important;
    } */
    .top_selling_img_v2
    {
        width: 100%;
        max-width: 280px !important;
        max-height: 280px !important;
        /* margin-bottom: 2rem; */
    }

    .content_top_selling_v2
    {
        /* padding: 17px; */
        display: flex;
        flex-direction: column;
        /* max-width: 280px !important; */
        width: 100%;
    }
    .product_details
    {
        height: 65px !important;
    }
    .img_category
    {
        width: 100%;
        height: 235px;
        /* background-image: url('../public/uploads/all/Owf4hyiLteS5jlfMDumrofDDpysLngHEWBuM0yGZ.png'); */
        background-image: url('../public/uploads/all/LerlHNylOl6dDHadtUav3qOLnD9dkbcZzPA7pEqM.png');
        margin-bottom: 69px;
    }
    .text_category
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 48px;
        font-weight: 700;
        line-height: 56px;
        letter-spacing: -0.0004em;
        text-align: left;
        padding: 87px 0px 87px 70px;
    }
    .button_for_checkout
    {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }
    .aiz-megabox > input:checked ~ .aiz-megabox-elem, .aiz-megabox > input:checked ~ .aiz-megabox-elem 
    {
        border-radius: 7px !important;
    }
    .w-50px, .size-50px {
        width: 60px !important;
    }
    .text_button_detail_page
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 18px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: center;

    }
    .text_brand
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 18px !important;
        font-weight: 400 !important;
        line-height: 26px;
        letter-spacing: 0em;
        text-align: left;
    }
    .text_who_sell
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 18px !important;
        font-weight: 400 !important;
        line-height: 26px;
        letter-spacing: 0em;
        text-align: left;
    }
    .small_content
    {
        height: 216px !important;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
    }
    .sub_content
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 18px;
        font-weight: 400;
        line-height: 26px;
        letter-spacing: 0em;
        text-align: left;
    }
    .product_name
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 40px !important;
        font-weight: 700;
        line-height: 48px !important;
        letter-spacing: -0.0004em;
        text-align: left;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
        width: 100%;
    }
    .price_product
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 42px !important;
        font-weight: 700 !important;
        line-height: 78px !important;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25 !important;
    }
    .top-100
    {
        top:73% !important;
    }
    .text_best_price
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 40px;
        font-weight: 700;
        line-height: 42px;
        letter-spacing: 0em;
        text-align: center;
        color: #FFFFFF;
        width: 100%;
        padding: 235px 35px 122px 35px; 
    }
    .name_product_top_selling
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 14px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        margin-bottom: 6px;
        color: #333333;
    }
    .price_product_top_selling
    {
        font-size: 20px;
        font-weight: 700;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25;

    }
    .content_top_selling
    {
        padding: 17px;
        display: flex;
        flex-direction: column;
        max-width: 280px !important;
        width: 100%;
    }
    .top_selling
    {
        height: auto;
        width: 25%;
        padding-right: 10px;
        padding-left: 10px;
        /* max-width: 282px !important; */
        /* border: 1px solid #D1D1D1;
        border-radius: 10px;
        transition: color 0.5s;
        z-index: 0;
        margin-right: 24px; */
    }
    .top_selling:first-child {
        padding-right: 10px ;
        padding-left: unset;
    }

    .top_selling:last-child {
        padding-left: 10px ;
        padding-right: unset;
    }
    .sub_top_selling
    {
        height: 100%;
        max-width: 282px !important;
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        transition: color 0.5s;
        z-index: 0;
    }
    .top_selling_news_product
    {
        max-height: 485px;
        width: 25%;
        padding-right: 10px;
        padding-left:10px; 
        padding-bottom: 30px;
    }
    .top_selling_news_product:nth-child(4n + 1)
    {
        padding-right:10px; 
        padding-left:unset; 
    }
    .top_selling_news_product:nth-child(3n + 4)
    {
        padding-right:unset; 
        padding-left:10px; 
    }
    .sub_top_selling_news_product
    {
        height: 100%;
        /* max-width: 282px !important; */
        /* width: 25% !important; */
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        transition: color 0.5s;
        z-index: 0;
    }
    .top_selling_img
    {
        width: 100%;
        max-width: 280px !important;
        max-height: 280px !important;
    }
    .img_product_top_selling
    {
        z-index: -2;
        position: relative;
        width: 100%;
        height: 280px;
        border: 1px solid #ffffff;
        border-radius: 10px;
    }
    .button_coupons
    {
        width: 57px ;
        /* height: 32px ; */
        border-radius: 8px ;
        border: 1px ;

    }
    .parent_coupons_showing
    {
        width: 25%;
        padding-right:20px;
    }
    .coupons_showing
    {
        max-width: 282.54px !important;
        height: auto !important;
        border: 1px !important;
        border-radius: 7px !important;
        padding: 25px 24px;
        display:flex;
        align-items: center
    }
    .text_button_coupons
    {
        width:auto !important;
        display: flex;
        flex-direction: column;
    }
    .bg-black-10, .hov-bg-black-10:hover {
        /* background-color: white !important; */
    }        
    .text_head_coupons
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #FFFFFF;
    }
    .parent_img_best_price
    {
        width:25%;
        height: auto;
        padding-right:10px;
    }
    .img_best_price
    {
        height:474px;
        border: 1px !important;
        border-radius: 10px !important;
        background-image: url("https://heromarket.vn/public/uploads/all/owiE8yVzKzZzBn4H9GCG97UPj71nfvPTYwRQxzgQ.png");
        background-size: 100% 100%;
    }
    .text_sub_coupons
    {
        font-family: 'Roboto';
        font-size: 14px;
        font-weight: 400;
        line-height: 21px;
        letter-spacing: 0em;
        text-align: left;
        color: #FFFFFF;
    }
    .new_product_section
    {
        height: auto;
        display: flex;
        padding-left: unset !important;
        padding-right: unset !important;
        flex-wrap: wrap;
        max-width: 1200px !important;
        /* width: 105% !important; */
    }
    .search-input-box > svg {
        top: 15px !important;
    }
    .ml-xl-4, .mx-xl-4 
    {
        margin-left: 5.5rem !important;
    }
    .fs-13
    {
        font-size : 1rem !important;
    }
    .search-input-box {
        max-width: 510px !important;
    }
    .search-input-box > input 
    {
        border-radius: 5px !important;
        overflow: hidden;
        height: 50px !important;
    }
    .search_bar
    {
        height: 102px !important;
    }
    :root{
        --blue: #3490f3;
        --gray: #9d9da6;
        --gray-dark: #8d8d8d;
        --secondary: #919199;
        --soft-secondary: rgba(145, 145, 153, 0.15);
        --success: #85b567;
        --soft-success: rgba(133, 181, 103, 0.15);
        --warning: #f3af3d;
        --soft-warning: rgba(243, 175, 61, 0.15);
        --light: #f5f5f5;
        --soft-light: #dfdfe6;
        --soft-white: #b5b5bf;
        --dark: #292933;
        --soft-dark: #1b1b28;
    }
    body
    {
        font-family: 'Quicksand', sans-serif !important;
    }
    
    .pagination .page-link,
    .page-item.disabled .page-link {
        min-width: 32px;
        min-height: 32px;
        line-height: 32px;
        text-align: center;
        padding: 0;
        border: 1px solid var(--soft-light);
        font-size: 0.875rem;
        border-radius: 0 !important;
        color: var(--dark);
    }
    .pagination .page-item {
        margin: 0 5px;
    }

    .aiz-carousel.coupon-slider .slick-track{
        margin-left: 0;
    }

    .form-control:focus {
        border-width: 2px !important;
    }
    .iti__flag-container {
        padding: 2px;
    }
    .modal-content {
        border: 0 !important;
        border-radius: 0 !important;
    }

    #map{
        width: 100%;
        height: 250px;
    }
    #edit_map{
        width: 100%;
        height: 250px;
    }

    .pac-container { z-index: 100000; }
    .info_seller
    {
        display: flex;
        position: relative;
        z-index: 1;
        bottom: 67px;
    }
    .info_seller_mobile
    {
        display: none;
    }
    .img_logo_seller
    {
        width: 200px;
        border-radius: 50%;
        height: 200px;
        border: 1px solid #e5e5e5;
    }
    .data_img_seller
    {
        max-width: 200px;
        width: 100%;
    }
    .name_seller
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 40px;
        font-weight: 700;
        line-height: 48px;
        letter-spacing: -0.0004em;
        text-align: left;
        padding: 99px 0px 53px 24px;
        /* max-width: 582px !important; */
        width: 100%;
    }
    .follow-button
    {
        padding: 99px 0px 53px 24px;
    }
    .follow-btn
    {
        max-width: 165px !important;
        height: 50px !important;
        border-radius: 8px !important;
        border: 1px solid #2E7F25 !important;
    }
    .relate_info_seller .text_head
    {
        font-family: 'Roboto',sans-serif !important;
                font-size: 20px;
                font-weight: 700;
                line-height: 32px;
                letter-spacing: -0.0004em;
                text-align: left;
                color:#333333;
                margin-bottom: 1rem;
    }
    .relate_info_seller
    {
        display: flex;
        height: auto;
    }
    .count_info_seller
    {
        padding-left: 90px;
    }

    .icon_info .text
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 26px;
        letter-spacing: 0em;
        color: #797979;
        padding-left: 8px;
    }
    .icon_info 
    {
        display: flex;
        margin-bottom: 1rem;
    }
    .social_link
    {
        display: flex;
    }
    .social_link .img_social_link
    {
        max-width: 32px;
        height: auto;
        margin-right: 1rem;
    }
    .img_certificates
    {
        width: 33.3%;
        padding-right: 30px;
        padding-bottom: 20px;
        max-height: 253px;
    }
    .parent_img_certificates
    {
        display: flex;
        flex-wrap: wrap;
    }
    .text_head_seller_info
    {
        margin-bottom: 30px !important;
    }
    .img_product_factories
    {
        max-height: 280px;
        width: 25%;
        padding: 0 24px 24px 0;
    }
    .mt-90
    {
        margin-top: 90px;
    }
    .home-slider .slick-slide img
    {
        height: 480px !important;
    }
    .home-banner-area
    {
        margin-bottom:74px !important;
    }
    .title_for_section
    {
        width: 30%;
    }
    .rfq_code
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px;
        font-weight: 700;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
    }
    .rfq_product_name
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
        display: block;
        max-width: 200px;
        word-wrap: break-word;
    }
    .rfq_attribute_name
    {
        font-family: 'Roboto', sans-serif !important;
        font-size: 12px !important;
        font-weight: 400 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #797979;
    }
    .setting_for_button
    {
        max-height: 55px;
        height: auto;
        max-width:800px;
        display: flex;
        flex-wrap: wrap
    }
    .title_data_text_resource
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: 0em;
        text-align: left;
        margin: 1.5rem 0px;
        height: auto;
    }
    .sub_data_text
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 20px;
        letter-spacing: 0em;
        text-align: left;
        margin-bottom: 1rem;
    }
    .container_data_text_resource
    {
        max-width: 1200px !important;
        width: 100%;
        margin: 0 auto;
        margin-top: 1rem;
        padding: 0 16px;
    }
    .p_data_text
    {
        height: auto;
        padding-top: 10px;
        padding-left:8px;
        display: flex;
        flex-direction: column;
    }
    .p_data_text span
    {
        margin-bottom:10px;
    }
    .title_sub_data_text
    {
        font-weight: 700 !important;
    }
    .color-7
    {
        color:#7E7E7E;
        font-size: 14px !important;
    }
    .price_product_before_discount
    {
        font-family: 'Roboto' ,sans-serif !important;
        font-size: 24px !important;
        font-weight: 700;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #7E7E7E;
    }
    .span_discount
    {
        display: flex;
        width: 55px;
        height: 29px;
        margin-bottom: 24px;
        background-color: #DEF9EC;
        font-family: 'Quicksand' ,sans-serif !important;
        font-size: 14px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #2E7F25;
        justify-content: center;
        align-items: center;
    }
    .tag_discount
    {
        position: absolute;
        width: 54.89px;
        height: 33.87px;
        top: 21px;
        padding: 10px 15px 10px 10px;
        border-radius: 0px 10px 10px 0px;
        gap: 10px;
        background-color: #2E7F25;
        border: 1px solid #2E7F25;
        font-family: 'Roboto' ,sans-serif !important;
        font-size: 16px;
        font-weight: 700;
        line-height: 12px;
        letter-spacing: 0em;
        text-align: left;
        color:#FFFFFF;
    }
    .hover_icon_product_detail
    {
        max-width: 50px;
        max-height: 50px;
        width: 100%;
        border: 1px solid #D7DEDB;
        border-radius: 8px;
        padding: 17px;
    }
    .size-16
    {
        font-size: 16px;
    }
    .coupon
    {
        top: unset
    }
    .data_coupons
    {
        display: flex;
        align-items: center;
        height: auto;
    }
    .img_seller_coupons
    {
        width: 20%;
    }
    .data_text_coupons
    {
        width: 70%;
        padding: 16px 10px 0px 10px;
    }
    .fixed-img-height
    {
        max-height: 470px;
    }

    /* Customer CSSS */
    .collapsible {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 1rem !important;
        font-weight: 700;
        background-color: white;
        color: #2E7F25;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        }
        .showing
        {
            background-color: #2E7F25;
            color: white;
        }
        
        .text_for_sub_label
        {
            font-family: 'Quicksand',sans-serif !important;
            font-size: 14px !important;
            font-weight: 400;
            color: #292933;
        }

        .section_information
        {
            margin-bottom: 12px;
        }

        .content {
        padding: 20px 18px;
        display: none;
        overflow: hidden;
        color: #292933;
        background-color: white;
        }

    @media screen and (max-width: 440px) {
        .nav-tabs .nav-item
        {
            margin-bottom: 1rem;
        }
        .product-info
        {
            padding: 40px 16px;
        }
        .setting_for_button
        {
            max-height: 100px;
            height: 100px;
            align-content: space-between;
        }
        .top_selling_v2 {
            width: 50%;
        }
        .icon_hover_products 
        {
            top: 65px;
            right: 75px;
        }
        .top_selling_v2:nth-child(2n+1){
            padding-right: 5px !important;
        }
        .top_selling_v2:nth-child(2n){
            padding-left: 5px !important;
            padding-right: 0px;
        }
        .top_selling_v2:nth-child(3n-3){
            padding-right: 5px !important;
        }
        .info_seller
        {
            display: none;
        }
        .info_seller_mobile
        {
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
            bottom: 67px;
            align-items: center;
        }
        .name_seller
        {
            padding: unset;
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .follow-button
        {
            padding: unset;
            display: flex;
            justify-content: center;
        }
        .description_shop {
            max-width: 270px;
        }
        .icon_info
        {
            align-items: center;
        }
        .count_info_seller
        {
            padding-left: 26px;
        }
        .mt-90
        {
            margin-top: 32px;
        }
        .filter_categories
        {
            display: none;
        }
        /* .d-none-mobile {
            display: none;
        } */

        .top_selling {
            width: 50% !important;
            margin-bottom: 10px;    
        }
        .parent_img_best_price
        {
            width: 50% !important;
            /* height: 310px !important; */
            padding-right: 10px !important;
            margin-bottom: 1rem !important;
        }
        .text_best_price
        {
            padding: 114px 16px 74px 16px !important;
        }
        .new_product_section
        {
            flex-wrap: wrap !important;
        }
        .top_selling_news_product
        {
            width: 50% !important;
        }
        .aiz-main-wrapper
        {
            overflow: hidden !important;
        }
        .parent_coupons_showing
        {
            width: 50% !important;
            padding-bottom: 20px;
        }
        .img_product_top_selling
        {
            height: 180px;
        }
        .img_best_price
        {
            height: 101%;
        }
        .parent_text_filter
        {
            justify-content:unset !important;
        }
        .home-slider
        {
            padding: 0 16px;
        }
        .top_selling:nth-child(2n+1)
        {
            padding-right:10px; 
            padding-left: unset;
        }
        .top_selling:nth-child(2n+2)
        {
            padding-left:10px; 
            padding-right:unset; 
        }

        .top_selling_news_product:nth-child(2n+1)
        {
            padding-right:10px; 
            padding-left:unset; 
        }
        .top_selling_news_product:nth-child(2n+2)
        {
            padding-left:10px; 
            padding-right:unset; 
        }

        .parent_coupons_showing:nth-child(2n+1)
        {
            padding-right:10px; 
        }
        .parent_coupons_showing:nth-child(2n+2)
        {
            padding-left:10px; 
            padding-right:unset; 
        }

        .sub_footer_mobile
        {
            display: flex;
            background-color: #F9F8F8;
            height: 220px;
            align-items: center;
            justify-content: space-evenly;
        }
        .sub_footer
        {
            display: none;
        }
        .home-slider .slick-slide img
        {
            height: 200px !important;
        }
        .home-banner-area
        {
            margin-bottom:unset !important;
        }
        .title_for_section
        {
            width: 40%;
        }
        .d-none-mobile
        {
            width: 60%;
            overflow-x: auto ;
            padding-left:16px;
        }
        ::-webkit-scrollbar{
            height: 0px;
            background: gray;
        }
    }
</style>


   

</head>
<body>
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column bg-white">

        <!-- Header -->
        @include('user_layout.inc.nav')

        @yield('content')

        @include('user_layout.inc.footer')

    </div>

 

   
{{-- 
    @include('frontend.partials.modal')
    
    @include('frontend.partials.account_delete_modal') --}}

    <div class="modal fade" id="addToCart">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader text-center p-3">
                    <i class="las la-spinner la-spin la-3x"></i>
                </div>
                <button type="button" class="close absolute-top-right btn-icon close z-1 btn-circle bg-gray mr-2 mt-2 d-flex justify-content-center align-items-center" data-dismiss="modal" aria-label="Close" style="background: #ededf2; width: calc(2rem + 2px); height: calc(2rem + 2px);">
                    <span aria-hidden="true" class="fs-24 fw-700" style="margin-left: 2px;">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>
    

    {{-- <div id="bannerformmodal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="bannerformmodal" aria-hidden="true"> --}}

    @yield('modal')

    <!-- SCRIPTS -->
    <script src="{{ static_asset('assets/js/vendors.js') }}" ></script>
	<script src="{{ static_asset('assets/js/custom-core.js') }}" ></script>
    <script src="{{ static_asset('plugins/jquery-validation/jquery.validate.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables/jquery.dataTables.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}" ></script>
	<script src="{{ static_asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}" ></script>
    <script type="text/javascript">
        @foreach (session('flash_notification', collect())->toArray() as $message)
	        AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
	    @endforeach
    </script>
    <script>
        $(".hover-user-top-menu .aiz-user-top-menu").on("mouseover", function (event) {
            $(".hover-user-top-menu").addClass('active');
        })
        .on("mouseout", function (event) {
            $(".hover-user-top-menu").removeClass('active');
        });
        
    </script>
    <script>
        $('#search').on('keyup', function(){
            search();
        });

        $('#search').on('focus', function(){
            search();
        });

        function showLoginModal() {
            @if (!Auth::check())
            {
                AIZ.plugins.notify('danger', "{{ translate('Please Login To Trigger Action') }}");
            }
            @endif
                // $('#login_modal').modal();
        }

        function search(){
            var searchKey = $('#search').val();
            
            if(searchKey.length > 0){
                $('body').addClass("typed-search-box-shown");

                $('.typed-search-box').removeClass('d-none');
                $('.search-preloader').removeClass('d-none');
                $.post('{{ route('search.ajax') }}', { _token: AIZ.data.csrf, search:searchKey}, function(data){
                    if(data == '0'){
                        // $('.typed-search-box').addClass('d-none');
                        $('#search-content').html(null);
                        $('.typed-search-box .search-nothing').removeClass('d-none').html('{{ translate('Sorry, nothing found for') }} <strong>"'+searchKey+'"</strong>');
                        $('.search-preloader').addClass('d-none');

                    }
                    else{
                        $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                        $('#search-content').html(data);
                        $('.search-preloader').addClass('d-none');
                    }
                });
            }
            else {
                $('.typed-search-box').addClass('d-none');
                $('body').removeClass("typed-search-box-shown");
            }
        }

        function updateNavCart(view,count){
            $('.cart-count').html(count);
            $('#cart_items').html(view);
        }

        function removeFromCart(key){
            $.post('{{ route('cart.removeFromCart') }}', {
                _token  : AIZ.data.csrf,
                id      :  key
            }, function(data){
                updateNavCart(data.nav_cart_view,data.cart_count);
                $('#cart-summary').html(data.cart_view);
                AIZ.plugins.notify('success', "{{ translate('Item has been removed from cart') }}");
                $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html())-1);
            });
        }

        function showAddToCartModal(id){
            if(!$('#modal-size').hasClass('modal-lg')){
                $('#modal-size').addClass('modal-lg');
            }
            $('#addToCart-modal-body').html(null);
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.post('{{ route('cart.showCartModal') }}', {_token: AIZ.data.csrf, id:id}, function(data){
                $('.c-preloader').hide();
                $('#addToCart-modal-body').html(data);
                AIZ.plugins.slickCarousel();
                AIZ.plugins.zoom();
                AIZ.extra.plusMinus();
                getVariantPrice();
            });
        }

        function addToCart(){
            var shop_id = $('#id_shop').val();
            
            @if(Auth::check() && Auth::user()->user_type != 'customer')
                AIZ.plugins.notify('warning', "{{ translate('Please Login as a customer to add products to the Cart.') }}");
                return false;
            @endif

            if(checkAddToCartValidity()) {
                $('#addToCart').modal();
                $('.c-preloader').show();
                $.ajax({
                    type:"POST",
                    url: '{{ route('cart.addToCart') }}',
                    data: $('#option-choice-form').serializeArray(),
                    success: function(data){
                       $('#addToCart-modal-body').html(null);
                       $('.c-preloader').hide();
                       $('#modal-size').removeClass('modal-lg');
                       $('#addToCart-modal-body').html(data.modal_view);
                       AIZ.extra.plusMinus();
                       AIZ.plugins.slickCarousel();
                       updateNavCart(data.nav_cart_view,data.cart_count);
                    }
                });
            }
            else{
                AIZ.plugins.notify('warning', "{{ translate('Please choose all the options') }}");
            }
        }

        function checkAddToCartValidity(){
            var names = {};
            $('#option-choice-form input:radio').each(function() { // find unique names
                names[$(this).attr('name')] = true;
            });
            var count = 0;
            $.each(names, function() { // then count them
                count++;
            });

            if($('#option-choice-form input:radio:checked').length == count){
                return true;
            }

            return false;
        }

        function SendRFQRequest(){
            var shop_id = $('#id_shop').val();
            var id_product = $("#id_product").val();
            @if(Auth::check() && Auth::user()->user_type != 'customer' && Auth::user()->user_type != 'enterprise')
                AIZ.plugins.notify('warning', "{{ translate('Please Login as a customer to send RFQ request.') }}");
                return false;
            @endif
            if(checkAddToCartValidity()) {
                $('#Rfq_request').modal('show');
            }
        }
    </script>
    
    @yield('script')
    @stack('append-scripts') 
</body>
</html>
