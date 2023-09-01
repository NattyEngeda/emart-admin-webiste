@extends('layouts.app')

@section('content')
	<div class="page-wrapper">
    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.driver_plural')}} <span class="itemTitle"></span></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href= "{!! route('vendors') !!}" >{{trans('lang.driver_plural')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.driver_details')}}</li>
            </ol>
        </div>

  </div>

   <div class="container-fluid">
   	  <div class="row">
   		  <div class="col-12">

            <div class="resttab-sec">
              <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
              <div class="menu-tab">
                <ul>
                  <li class="active">
                      <a href="{{route('drivers.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                  </li>
									<li>
                      <a href="{{route('drivers.vehicle',$id)}}">{{trans('lang.vehicle')}}</a>
                  </li>
                  <li>
                      <a href="{{route('drivers.ride',$id)}}">{{trans('lang.rides')}}</a>
                  </li>
                  <li>
                      <a href="{{route('payoutRequests.drivers.view',$id)}}">{{trans('lang.tab_payouts')}}</a>
                  </li>


                </ul>

              </div>

            </div>

        <div class="row vendor_payout_create">
            <div class="vendor_payout_create-inner">
                <fieldset>
                    <legend>{{trans('lang.driver_details')}}</legend>
                          <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                          <div class="col-7" class="driver_name">
                              <span class="driver_name" id="driver_name"></span>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.email')}}</label>
                          <div class="col-7">
                          <span class="email"></span>
                          </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                          <div class="col-7">
                          <span class="phone"></span>
                          </div>
                        </div>
                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.profile_image')}}</label>
                          <div class="col-7 profile_image">
                          </div>
                          </div>
                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.service_type')}}</label>
                          <div class="col-7">
                          <span class="service_type"></span>
                          </div>
                        </div>
                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.type')}}</label>
                          <div class="col-7">
                          <span class="type"></span>
                          </div>
                        </div>
                        <div class="company_details" style="display:none">
                        <div class="form-group row width-50 ">
                          <label class="col-3 control-label">{{trans('lang.company_name')}}</label>
                          <div class="col-7">
                          <span class="company_name"></span>
                          </div>
                        </div>
                        <div class="form-group row width-50 ">
                          <label class="col-3 control-label">{{trans('lang.company_address')}}</label>
                          <div class="col-7">
                          <span class="company_address"></span>
                          </div>
                        </div>
                        </div>

                </fieldset>

                <fieldset>
                  <legend>{{trans('lang.bankdetails')}}</legend>
                        <div class="form-group row width-50">
                          <label class="col-4 control-label">{{
                          trans('lang.bank_name')}}</label>
                          <div class="col-7">
                          <span class="bank_name"></span>
                          </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-4 control-label">{{
                          trans('lang.branch_name')}}</label>
                          <div class="col-7">
                          <span class="branch_name"></span>
                          </div>
                        </div>


                        <div class="form-group row width-50">
                          <label class="col-4 control-label">{{
                          trans('lang.holer_name')}}</label>
                          <div class="col-7">
                          <span class="holer_name"></span>
                          </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-4 control-label">{{
                          trans('lang.account_number')}}</label>
                          <div class="col-7">
                          <span class="account_number"></span>
                          </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-4 control-label">{{
                          trans('lang.other_information')}}</label>
                          <div class="col-7">
                          <span class="other_information"></span>
                          </div>
                        </div>


                    </fieldset>
                  </div>
              </div>
                <div class="form-group col-12 text-center btm-btn">
                  <a href="{!! route('drivers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                </div>

          </div>
        </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

var id = "<?php echo $id;?>";
var database = firebase.firestore();
var ref = database.collection('users').where("id","==",id);
var photo ="";
var vendorOwnerId = "";
var vendorOwnerOnline = false;

var placeholderImage = '';
var placeholder = database.collection('settings').doc('placeHolderImage');

placeholder.get().then( async function(snapshotsimage){
  var placeholderImageData = snapshotsimage.data();
  placeholderImage = placeholderImageData.image;
})

$(document).ready(async function(){
  		
    jQuery("#data-table_processing").show();

  		ref.get().then( async function(snapshots){

        var dirver = snapshots.docs[0].data();
        console.log(dirver);
        $(".driver_name").text(dirver.firstName);
        $(".email").text(dirver.email);
        $(".phone").text(dirver.phoneNumber);

        $(".service_type").text(dirver.serviceType);
        if(dirver.isCompany != false){
          $(".type").text('Company');
          $(".company_details").show();
          $(".company_address").text(dirver.companyAddress)
          $(".company_name").text(dirver.companyName)
        }else{
          $(".type").text('Individual');
        }
        var image="";
        if (dirver.profilePictureURL) {
          image='<img width="200px" id="" height="auto" src="'+dirver.profilePictureURL+'">';
        }else{
          image='<img width="200px" id="" height="auto" src="'+placeholderImage+'">';
        }
        $(".profile_image").html(image);
        $(".bank_name").text(dirver.userBankDetails.bankName);
        $(".branch_name").text(dirver.userBankDetails.branchName);
        $(".holer_name").text(dirver.userBankDetails.holderName);
        $(".account_number").text(dirver.userBankDetails.accountNumber);
        $(".other_information").text(dirver.userBankDetails.otherDetails);

      
        jQuery("#data-table_processing").hide();
  	
		  })

})

</script>

@endsection
