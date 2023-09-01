@extends('layouts.app')

@section('content')

<div class="page-wrapper">

  <div class="row page-titles">

    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">{{trans('lang.rides')}}</h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

        <?php if (isset($_GET['eid']) && $_GET['eid'] != '') { ?>
          <li class="breadcrumb-item"><a href="{{route('drivers.ride',$_GET['eid'])}}">{{trans('lang.order_plural')}}</a>
          </li>
        <?php } else { ?>
          <li class="breadcrumb-item"><a href="javascript:window.history.go(-1);">{{trans('lang.rides')}}</a></li>
        <?php } ?>

        <li class="breadcrumb-item">{{trans('lang.ride_edit')}}</li>
      </ol>
    </div>
  </div>

  <div class="card-body">
    <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
      {{trans('lang.processing')}}</div>

    <div class="order_detail" id="order_detail">
      <div class="order_detail-top">
        <div class="row">
          <div class="order_edit-genrl col-md-4">

            <h3>{{trans('lang.general_details')}}</h3>
            <div class="order_detail-top-box">

              <div class="form-group row widt-100 gendetail-col">
                <label class="col-12 control-label"><strong>{{trans('lang.date_created')}} : </strong><span
                    id="createdAt"></span></label>
              </div>

              <div class="form-group row widt-100 gendetail-col payment_method">
                <label class="col-12 control-label"><strong>{{trans('lang.payment_methods')}}: </strong><span
                    id="payment_method"></span></label>
              </div>

              {{--<div class="form-group row widt-100 gendetail-col">
                <label class="col-12 control-label"><strong>{{trans('lang.order_type')}}:</strong> <span
                    id="order_type"></span></label>
              </div>--}}

              <div class="form-group row widt-100 gendetail-col">
                <label class="col-12 control-label"><strong>{{trans('lang.ridetype')}}:</strong> <span
                    id="rideType"></span></label>
              </div>

              <div class="form-group row width-100 ">
                <label class="col-3 control-label">{{trans('lang.status')}}:</label>
                <div class="col-7">
                  <select id="order_status" class="form-control">
                    <option value="Order Placed" id="order_placed">{{ trans('lang.order_placed')}}</option>
                    <option value="Order Accepted" id="order_accepted">{{ trans('lang.order_accepted')}}</option>
                    <option value="Order Rejected" id="order_rejected">{{ trans('lang.order_rejected')}}</option>
                    <option value="Driver Pending" id="driver_pending">{{ trans('lang.driver_pending')}}</option>
                    <option value="Driver Rejected" id="driver_rejected">{{ trans('lang.driver_rejected')}}</option>
                    <option value="Order Shipped" id="order_shipped">{{ trans('lang.order_shipped')}}</option>
                    <option value="In Transit" id="in_transit">{{ trans('lang.in_transit')}}</option>
                    <option value="Order Completed" id="order_completed">{{ trans('lang.order_completed')}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group row width-100">
                <label class="col-3 control-label"></label>
                <div class="col-7 text-right">
                  <button type="button" class="btn btn-primary save_order_btn"><i class="fa fa-save"></i>
                    {{trans('lang.update')}}</button>
                </div>
              </div>
            </div>

          </div>

          <div class="order_edit-genrl col-md-4">
            <h3>{{ trans('lang.billing_details')}}</h3>

            <div class="address order_detail-top-box">
              <div class="address order_detail-top-box">
                <div class="form-group row widt-100 gendetail-col">
                  <label class="col-12 control-label"><strong>{{trans('lang.name')}}
                      : </strong><span id="billing_name"></span></label>

                </div>
                <div class="form-group row widt-100 gendetail-col">
                  <label class="col-12 control-label"><strong>{{trans('lang.address')}}
                      : </strong><span id="billing_line1"></span> <span id="billing_line2"></span><span
                      id="billing_country"></span></label>

                </div>

                <div class="form-group row widt-100 gendetail-col">
                  <label class="col-12 control-label"><strong>{{trans('lang.email_address')}}
                      : </strong><span id="billing_email"></span></label>

                </div>

                <p><strong>{{trans('lang.phone')}}:</strong>
                  <span id="billing_phone"></span>
                </p>
              </div>
            </div>

            <div class="order_addre-edit col-md-4 driver_details_hide">
              <h3>{{ trans('lang.driver_detail')}}</h3>

              <div class="address order_detail-top-box">
                <p>
                  <span id="driver_firstName"></span> <span id="driver_lastName"></span><br>
                </p>
                <p><strong>{{trans('lang.email_address')}}:</strong>
                  <span id="driver_email"></span>
                </p>
                <p><strong>{{trans('lang.phone')}}:</strong>
                  <span id="driver_phone"></span>
                </p>
                <p><strong>{{trans('lang.car_name')}}:</strong>
                  <span id="driver_carName"></span>
                </p>
                <p><strong>{{trans('lang.car_number')}}:</strong>
                  <span id="driver_carNumber"></span>
                </p>
              </div>
            </div>

          </div>

        </div>

        <div class="order-deta-btm mt-4">
          <div class="row">
            <div class="col-md-8 order-deta-btm-left">
              <div class="order-items-list ">
                <div class="row">
                  <div class="col-md-12">
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-valign-middle">

                      <thead>
                        <tr>
                          <th>{{trans('lang.from')}}</th>
                          <th>{{trans('lang.to')}}</th>
                          <th>{{trans('lang.price')}}</th>
                          <th>{{trans('lang.total')}}</th>
                        </tr>

                      </thead>

                      <tbody id="order_products">

                      </tbody>

                    </table>
                  </div>
                </div>
              </div>

              <div class="order-data-row order-totals-items">
                <div class="row">
                  <div class="col-md-12">
                    <table class="order-totals">
                      <tbody id="order_products_total">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 order-deta-btm-right">
              <div class="resturant-detail">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-header-title">{{trans('lang.driver_detail')}}</h4>
                  </div>

                  <div class="card-body">
                    <a href="#" class="row redirecttopage" id="resturant-view">
                      <div class="col-4">
                        <img src="" class="resturant-img rounded-circle" alt="driver" width="70px" height="70px">
                      </div>
                      <div class="col-8">
                        <h4 class="vendor-title"></h4>
                      </div>
                    </a>

                    <h5 class="contact-info">{{trans('lang.contact_info')}}:</h5>

                    <p><strong id="vendor_phone1">{{trans('lang.phone')}}:</strong>
                      <span id="vendor_phone"></span>
                    </p>
                    <h5 class="contact-info">{{trans('lang.car_info')}}:</h5>
                    <a href="#" class="row redirecttopage" id="car-view">
                      <div class="col-4">
                        <img src="" class="car-img rounded-circle" alt="car" width="70px" height="70px">
                      </div>

                    </a>
                    <br>
                    <p><strong id="driver_carName1" style="width:auto !important;">{{trans('lang.car_name')}}:</strong>
                      <span id="driver_carName"></span>
                    </p> <br>
                    <p><strong id="driver_carNumber1" style="width:auto !important;">{{trans('lang.car_number')}}:</strong>
                      <span id="driver_carNumber"></span>
                    </p> <br>
                    <p><strong id="driver_car_make1" style="width:auto !important;">{{trans('lang.car_make')}}:</strong>
                      <span id="driver_car_make"></span>
                    </p>
                    

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>



    <div class="form-group col-12 text-center btm-btn">
      <button type="button" class="btn btn-primary save_order_btn"><i class="fa fa-save"></i>
        {{trans('lang.save')}}</button>

      <?php if (isset($_GET['eid']) && $_GET['eid'] != '') { ?>
        <a href="{{route('vendors.orders',$_GET['eid'])}}" class="btn btn-default"><i
            class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
      <?php } else { ?>
        <a href="javascript:window.history.go(-1);" class="btn btn-default"><i
            class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
      <?php } ?>

    </div>

  </div>



</div>
</div>

@endsection

@section('style')

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>

<script type="text/javascript">

  var adminCommission = 0;
  var id_rendom = "<?php echo uniqid(); ?>";
  var id = "<?php echo $id; ?>";
  var driverId = '';
  var fcmToken = '';
  var old_order_status = '';
  var payment_shared = false;
  var deliveryChargeVal = 0;
  var tip_amount_val = 0;
  var tip_amount = 0;
  var vendorname = '';
  var database = firebase.firestore();
  var ref = database.collection('rides').where("id", "==", id);
  var append_procucts_list = '';
  var append_procucts_total = '';
  var total_price = 0;
  var currentCurrency = '';
  var currencyAtRight = false;
  var refCurrency = database.collection('currencies').where('isActive', '==', true);
  var orderPreviousStatus = '';
  var orderTakeAwayOption = false;
  var manfcmTokenVendor = '';
  var manname = '';
  refCurrency.get().then(async function (snapshots) {
    var currencyData = snapshots.docs[0].data();
    currentCurrency = currencyData.symbol;
    currencyAtRight = currencyData.symbolAtRight;
  });


  var geoFirestore = new GeoFirestore(database);
  var place_image = '';
  var ref_place = database.collection('settings').doc("placeHolderImage");
  ref_place.get().then(async function (snapshots) {
    var placeHolderImage = snapshots.data();
    place_image = placeHolderImage.image;
  });

  $(document).ready(function () {

    var alovelaceDocumentRef = database.collection('vendor_orders').doc();
    if (alovelaceDocumentRef.id) {
      id_rendom = alovelaceDocumentRef.id;
    }
    $(document.body).on('click', '.redirecttopage', function () {
      var url = $(this).attr('data-url');
      window.location.href = url;
    });

    jQuery("#data-table_processing").show();

    ref.get().then(async function (snapshots) {
      var ride = snapshots.docs[0].data();

      append_procucts_list = document.getElementById('order_products');
      append_procucts_list.innerHTML = '';

      append_procucts_total = document.getElementById('order_products_total');
      append_procucts_total.innerHTML = '';


      $("#billing_name").text(ride.author.firstName + " "+ ride.author.lastName);
      
      
      var billingAddressstring = '';

      $("#trackng_number").text(id);
      if (ride.author.shippingAddress.hasOwnProperty('line1')) {
        $("#billing_line1").text(ride.author.shippingAddress.line1);
      }
      if (ride.author.shippingAddress.hasOwnProperty('line2')) {
        billingAddressstring = billingAddressstring + ride.author.shippingAddress.line2;
      }
      if (ride.author.shippingAddress.hasOwnProperty('city')) {
        billingAddressstring = billingAddressstring + ", " + ride.author.shippingAddress.city;
      }

      if (ride.author.shippingAddress.hasOwnProperty('postalCode')) {
        billingAddressstring = billingAddressstring + ", " + ride.author.shippingAddress.postalCode;
      }

      if (ride.author.hasOwnProperty('phoneNumber')) {
        $("#billing_phone").text(ride.author.phoneNumber);
      }

      $("#billing_line2").text(billingAddressstring);

      if (ride.author.shippingAddress.hasOwnProperty('country')) {

        $("#billing_country").text(ride.author.shippingAddress.country);

      }

      if (ride.author.shippingAddress.hasOwnProperty('email')) {
        $("#billing_email").html('<a href="mailto:' + ride.author.email + '">' + ride.author.email + '</a>');
      }

      if (ride.createdAt) {
        var date1 = ride.createdAt.toDate().toDateString();
        var date = new Date(date1);
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = date.getFullYear();
        var createdAt_val = yyyy + '-' + mm + '-' + dd;
        var time = ride.createdAt.toDate().toLocaleTimeString('en-US');

        $('#createdAt').text(createdAt_val + ' ' + time);
      }

      if (ride.paymentMethod) {

        if (ride.paymentMethod == 'cod') {
          $('#payment_method').text('{{trans("lang.cash_on_delivery")}}');
        } else if (ride.paymentMethod == 'paypal') {
          $('#payment_method').text('{{trans("lang.paypal")}}');
        } else {
          $('#payment_method').text(ride.paymentMethod);
        }

      }
      if (ride.hasOwnProperty('takeAway') && ride.takeAway) {
        $('#driver_pending').hide();
        $('#driver_rejected').hide();
        $('#order_shipped').hide();
        $('#in_transit').hide();
       // $('#order_type').text('{{trans("lang.order_takeaway")}}');
        $('.payment_method').hide();
        orderTakeAwayOption = true;

      } else {
     //  $('#order_type').text('{{trans("lang.order_delivery")}}');
        $('.payment_method').show();

      }

      if (ride.hasOwnProperty('rideType')) {
        $('#rideType').text(ride.rideType);
      } else {

      }

      if ((ride.driver != '' && ride.driver != undefined) && (ride.takeAway)) {

        $('#driver_carName').text(ride.driver.carName);
        $('#driver_carNumber').text(ride.driver.carNumber);
        $('#driver_email').html('<a href="mailto:' + ride.driver.email + '">' + ride.driver.email + '</a>');
        $('#driver_firstName').text(ride.driver.firstName);
        $('#driver_lastName').text(ride.driver.lastName);
        $('#driver_phone').text(ride.driver.phoneNumber);

      } else {
        $('.order_edit-genrl').removeClass('col-md-4').addClass('col-md-6');
        $('.order_addre-edit').removeClass('col-md-4').addClass('col-md-6');
        $('.driver_details_hide').empty();

      }

      if (ride.driverID != '' && ride.driverID != undefined) {
        driverId = ride.driverID;
      }
      if (ride.vendor && ride.vendor.author != '' && ride.vendor.author != undefined) {
        vendorAuthor = ride.vendor.author;
      }
      fcmToken = ride.author.fcmToken;
      if (ride.driver != undefined) {
        drivername = ride.driver.firstName;
      } else {
        drivername = '';
      }



      customername = ride.author.firstName;

      driverID = ride.driverID;
      old_order_status = ride.status;
      if (ride.payment_shared != undefined) {
        payment_shared = ride.payment_shared;
      }
      var productsListHTML = buildHTMLProductsList(snapshots);
      var productstotalHTML = buildHTMLProductstotal(ride);

      if (productsListHTML != '') {
        append_procucts_list.innerHTML = productsListHTML;
      }

      if (productstotalHTML != '') {
        append_procucts_total.innerHTML = productstotalHTML;
      }

      orderPreviousStatus = ride.status;
      if (ride.hasOwnProperty('paymentMethod')) {
        orderPaymentMethod = ride.paymentMethod;
      }

      $("#order_status option[value='" + ride.status + "']").attr("selected", "selected");
      if (ride.status == "Order Rejected" || ride.status == "Driver Rejected") {
        $("#order_status").prop("disabled", true);
      }
      var price = 0;
      

      if (ride.driverID) {
        var driver = database.collection('users').where("id", "==", ride.driverID);

        driver.get().then(async function (snapshotsnew) {
          if(!snapshotsnew.empty){
          var driverdata = snapshotsnew.docs[0].data();
         

         if (driverdata.id) {
            var route_view = '{{route("drivers.view",":id")}}';
            route_view = route_view.replace(':id', driverdata.id);

            $('#resturant-view').attr('data-url', route_view);
          }
          if (driverdata.profilePictureURL) {
            $('.resturant-img').attr('src', driverdata.profilePictureURL);
          } else {
            $('.resturant-img').attr('src', place_image);
          }
          if (driverdata.firstName) {
            $('.vendor-title').html(driverdata.firstName + ' ' + driverdata.lastName);
          }

          if (driverdata.email) {
            $('#vendor_email').html(driverdata.email);
          }
          if (driverdata.phoneNumber) {
            $('#vendor_phone').text(driverdata.phoneNumber);
          }
          if (driverdata.id) {
            var route_view = '{{route("drivers.view",":id")}}';
            route_view = route_view.replace(':id', driverdata.id);

            $('#resturant-car').attr('data-url', route_view);
          }
          if (driverdata.carPictureURL) {
            $('.car-img').attr('src', driverdata.carPictureURL);
          } else {
            $('.car-img').attr('src', place_image);
          }
          if (driverdata.carName) {
            $('#driver_carName').html(driverdata.carName);
          }

          if (driverdata.carNumber) {
            $('#driver_carNumber').html(driverdata.carNumber);
          }
          if (driverdata.carMakes) {
            $('#driver_car_make').text(driverdata.carMakes);
          }
        }
        else {
        
                     

          $('.resturant-img').hide();
          $('.vendor-title').text('Driver deleted');
          $('#vendor_email').hide();
          $('#vendor_phone').hide();
         
          $('#resturant-car').hide();
          $('.car-img').hide();
          $('#driver_carName').hide();
          $('#driver_carNumber').hide();
          $('#driver_car_make').hide();

          $('#vendor_phone1').hide();
         
        
       
         $('#driver_carName1').hide();
         $('#driver_carNumber1').hide();
         $('#driver_car_make1').hide();
          
          $('.contact-info').hide();
        }
        });

      }
      
      ref.get().then(async function (snapshotsride) {

        snapshotsride.docs.forEach((listval) => {
          database.collection('rides').where('id', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function (orderSnapshots) {
            var count_order_complete = orderSnapshots.docs.length;
          });

        });
      });

      jQuery("#data-table_processing").hide();
    })


    $(".save_order_btn").click(async function () {

      var clientName = $(".client_name").val();
      var orderStatus = $("#order_status").val();
      if (old_order_status != orderStatus) {
        database.collection('rides').doc(id).update({ 'status': orderStatus }).then(async function (result) {

          if (orderStatus == "Order Completed") {
            manname = customername;
          } else {
            manfcmTokenRide = fcmToken;
            manname = drivername;
          }
          if (orderStatus != orderPreviousStatus && payment_shared == false) {
            if (orderStatus == 'Order Completed') {

              vendorAmount = parseFloat(total_price) + (parseFloat(adminCommission));
              driverAmount = parseFloat(deliveryChargeVal) - parseFloat(tip_amount);
              var vendor = database.collection('users').where("driverID", "==", driverID);
              var vendorWallet = 0;
              await database.collection('order_transactions').doc(id_rendom).set({ 'date': vendorWallet, 'driverAmount': driverAmount, 'driverId': driverID, 'id': id_rendom, 'order_id': id }).then(async function (result) {

                if (driverId && driverAmount) {
                  var driver = database.collection('users').where("id", "==", driverId);
                  await driver.get().then(async function (snapshotsdriver) {
                    var driverdata = snapshotsdriver.docs[0].data();
                    if (driverdata) {
                      if (isNaN(driverdata.wallet_amount) || driverdata.wallet_amount == undefined) {
                        driverWallet = 0;
                      } else {
                        driverWallet = driverdata.wallet_amount;
                      }
                      if (orderPaymentMethod == 'cod' && orderTakeAwayOption == true) {
                        driverWallet = driverWallet - parseFloat(total_price) - parseFloat(driverAmount);
                      } else {
                        driverWallet = driverWallet + driverAmount;
                      }
                      if (!isNaN(vendorWallet)) {
                        await database.collection('users').doc(driverdata.id).update({ 'wallet_amount': driverWallet }).then(async function (result) {

                        });
                      }

                    }
                  })
                }
              });

              await database.collection('rides').doc(id).update({ 'payment_shared': true }).then(async function (result) {
              });
            }

            await $.ajax({
              type: 'POST',
              url: "<?php echo route('order-status-notification'); ?>",
              data: {
                _token: '<?php echo csrf_token() ?>',
                'fcm': manfcmTokenVendor,
                'drivername': manname,
                'orderStatus': orderStatus
              },
              success: function (data) {

                if (orderPreviousStatus != 'Order Rejected' && orderPreviousStatus != 'Driver Rejected' && orderPaymentMethod != 'cod' && orderTakeAwayOption == false) {
                  if (orderStatus == 'Order Rejected' || orderStatus == 'Driver Rejected') {
                    var walletId = "<?php echo uniqid(); ?>";
                    var canceldateNew = new Date();
                    var orderCancelDate = new Date(canceldateNew.setHours(23, 59, 59, 999));
                    database.collection('wallet').doc(walletId).set({
                      'amount': parseFloat(orderPaytableAmount),
                      'date': orderStatus,
                      'id': walletId,
                      'payment_status': 'success',
                      'user_id': orderCustomerId,
                      'paymentMethod': 'Cancelled Order Payment'
                    }).then(function (result) {
                      window.location.href = '{{ route("orders")}}';
                    })
                  } else {

                    window.location.href = '{{ route("orders")}}';
                  }
                } else {
                  window.location.href = '{{ route("orders")}}';
                }

              }
            });

          }

          await $.ajax({
            type: 'POST',
            url: "<?php echo route('order-status-notification'); ?>",
            data: { _token: '<?php echo csrf_token() ?>', 'fcm': fcmToken, 'drivername': drivername, 'orderStatus': orderStatus },
            success: function (data) {
              <?php if (isset($_GET['eid']) && $_GET['eid'] != '') { ?>
                window.location.href = "{{ route('driver.ride',$_GET['eid']) }}";
              <?php } else { ?>
                window.location.href = '{{ route("rides")}}';
              <?php } ?>
            }
          });

        });
      }

    })

  })

  function buildHTMLProductsList(snapshots) {
    var html = '';
    var alldata = [];
    var number = [];
    snapshots.docs.forEach((listval) => {
      var datas = listval.data();
      datas.id = listval.id;
      alldata.push(datas);
    });



    var count = 0;
    alldata.forEach((listval) => {

      var val = listval;
      
      html = html + '<tr>';

      if (val.size) {
        html = html + '<div class="type"><span>{{trans("lang.type")}} :</span><span class="ext-size">' + val.size + '</span></div>';
      }

      price_item = parseFloat(val.subTotal).toFixed(2);

      totalProductPrice = price_item;
      var extras_price = 0;

      totalProductPrice = parseFloat(totalProductPrice).toFixed(2);

      if (currencyAtRight) {
        price_val = price_item + "" + currentCurrency;
        extras_price_val = extras_price + "" + currentCurrency;
        totalProductPrice_val = totalProductPrice + "" + currentCurrency;
      } else {
        price_val = currentCurrency + "" + price_item;
        extras_price_val = currentCurrency + "" + extras_price;
        totalProductPrice_val = currentCurrency + "" + totalProductPrice;
      }

      html = html + '</div></div></td>';
      html = html + '<td>' + val.sourceLocationName + '</td><td>' + val.destinationLocationName + '</td><td>' + price_val + '</td><td>  ' + totalProductPrice_val + '</td>';

      html = html + '</tr>';
      total_price += parseFloat(totalProductPrice);
    });
    totalProductPrice = 0;

    return html;
  }

  function buildHTMLProductstotal(snapshotsProducts) {
    var html = '';
    var alldata = [];
    var number = [];
    var adminCommission = snapshotsProducts.adminCommission;
    var adminCommissionType = snapshotsProducts.adminCommissionType;
    var discount = snapshotsProducts.discount;
    var couponCode = snapshotsProducts.couponCode;
    var extras = snapshotsProducts.extras;
    var extras_price = snapshotsProducts.extras_price;
    var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
    var tip_amount = snapshotsProducts.tip_amount;
    var notes = snapshotsProducts.notes;
    var status = snapshotsProducts.status;
    var products = snapshotsProducts.products;
    var deliveryCharge = snapshotsProducts.vehicleType.delivery_charges_per_km;

    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    if (products) {

      products.forEach((product) => {
        var val = product;
      });
    }

    if (currencyAtRight) {
      total_price_val = total_price + "" + currentCurrency;
    } else {
      total_price_val = currentCurrency + "" + total_price;
    }
    html = html + '<tr><td class="label">{{trans("lang.total")}}</td><td>	' + total_price_val + '</td></tr>';

    if (intRegex.test(discount) || floatRegex.test(discount)) {

      discount = parseFloat(discount).toFixed(2);
      total_price -= parseFloat(discount);

      if (currencyAtRight) {
        discount_val = discount + "" + currentCurrency;
      } else {
        discount_val = currentCurrency + "" + discount;
      }

      couponCode_html = '';
      if (couponCode) {
        couponCode_html = '</br><small>{{trans("lang.coupon_codes")}} :' + couponCode + '</small>';
      }
      html = html + '<tr><td class="label">{{trans("lang.discount")}}' + couponCode_html + '</td><td class="discount">-' + discount_val + '</td></tr>';
    }

    var tax = 0;
    taxlabel = '';
    taxlabeltype = '';
    try {
      if (snapshotsProducts.tax) {
        if (snapshotsProducts.taxType && snapshotsProducts.tax) {
          if (snapshotsProducts.taxType == "percent") {
            tax = (snapshotsProducts.tax * total_price) / 100;
            taxlabeltype = "%";
          } else {
            tax = snapshotsProducts.tax;
            taxlabeltype = "fix";
          }
          
        }
      }
    } catch (error) {

    }
    if (!isNaN(tax) && tax != 0) {
      var tax_fixed = parseFloat(tax).toFixed(2)
      if (currencyAtRight) {
        html = html + '<tr><td class="label">{{trans("lang.tax")}}</td><td class="deliveryCharge">+' + tax_fixed + '' + currentCurrency + '(' + snapshotsProducts.tax + ' ' + taxlabeltype + ')</td></tr>';
      } else {
        html = html + '<tr><td class="label">{{trans("lang.tax")}}</td><td class="deliveryCharge">+' + currentCurrency + tax_fixed + '( ' + snapshotsProducts.tax + ' ' + taxlabeltype + ')</td></tr>';
      }

      total_price = total_price + parseFloat(tax);
    }

    var total_item_price = total_price;
    if (intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {

      tip_amount = parseFloat(tip_amount).toFixed(2);
      total_price += parseFloat(tip_amount);
      total_price = parseFloat(total_price).toFixed(2);

      if (currencyAtRight) {
        tip_amount_val = tip_amount + "" + currentCurrency;
      } else {
        tip_amount_val = currentCurrency + "" + tip_amount;
      }
      if (tip_amount) {
        html = html + '<tr><td class="label">{{trans("lang.tip_amount")}}</td><td class="tip_amount_val">+' + tip_amount_val + '</td></tr>';
      }
    }

    if (currencyAtRight) {
      total_price_val = parseFloat(total_price).toFixed(2) + "" + currentCurrency;
    } else {
      total_price_val = currentCurrency + "" + parseFloat(total_price).toFixed(2);
    }

    html = html + '<tr><td class="label">{{trans("lang.total_amount")}}</td><td class="total_price_val">' + total_price_val + '</td></tr>';

    if (adminCommission != undefined && adminCommissionType != undefined) {
      var commission = 0;
      
      if (adminCommissionType == "Percent") {
        commission = (total_item_price * parseFloat(adminCommission)) / 100;
      } else {
        commission = parseFloat(adminCommission);
      }
      adminCommission = commission;
    } else if (adminCommission != undefined) {
      var commission = parseFloat(adminCommission);
      adminCommission = commission;
    }

    if (adminCommission) {

      adminCommission = parseFloat(adminCommission).toFixed(2);
      if (currencyAtRight) {
        adminCommission_val = adminCommission + "" + currentCurrency;
      } else {
        adminCommission_val = currentCurrency + "" + adminCommission;
      }
      html = html + '<tr><td class="label"><small>( {{trans("lang.admin_commission")}} </small></td><td class="adminCommission_val"><small>' + adminCommission_val + ')</small></td></tr>';
    }

    if (notes) {


      html = html + '<tr><td class="label">{{trans("lang.notes")}}</td><td class="adminCommission_val">' + notes + '</td></tr>';
    }


    return html;
  }

</script>

@endsection