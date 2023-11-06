$(document).ready(function(){
  $(document).on('change','#retail_units_id',function(e){
var unit_id=$("#unit_id").val();
if(unit_id==''){
  alert("اختر الوحده الرئيسية اولا");
  $("#retail_units_id").val("");
  
  return false;
}

 if($(this).val!=''){  
$("#retail_uom_idDiv").show();
var retail_units_id=$("#retail_units_id").val();
if(retail_units_id!=''){
  $(".relatied_retial_counter").show();
}
   }else{
    $(".relatied_retial_counter").hide();
    $("#retail_uom_idDiv").hide();
   }
  
     
   
  });


  $(document).on('change','#item_type',function(e){
    if($(this).val()==2){
    
      $(".relatied_retial_counter_type").show();
      
    
       }else{
        $(".relatied_retial_counter_type").hide();
     
       }

      });



  $(document).on('change','#unit_id',function(e){
    if($(this).val()!=''){
    var name=$("#unit_id option:selected").text();  
    $(".parentunitname").text(name); 
    
    } 
            
         });

   $(document).on('change','#retail_units_id',function(e){
    if($(this).val()!=''){
    var name=$("#retail_units_id option:selected").text();  
    $(".childunitname").text(name); 
    $(".relatied_retial_counter").show();   

    }else{
      $(".childunitname").text(''); 
      $(".relatied_retial_counter").hide();   

    }
      
   });


   $(document).on('click','#do_add_item_card',function(e){
   var name=$("#name").val();
   if(name==""){
    alert("من فضلك ادخل اسم الصنف");
    $("#name").focus();
    return false;
   }

   var item_type=$("#item_type").val();
   if(item_type==""){
    alert("من فضلك ادخل نوع الصنف");
    $("#item_type").focus();
    return false;
   }

   var items_categories_id=$("#items_categories_id").val();
   if(items_categories_id==""){
    alert("من فضلك اختر فئة الصنف");
    $("#items_categories_id").focus();
    return false;
   }

   var unit_id=$("#unit_id").val();
   if(unit_id==""){
    alert("من فضلك اختر الوحده  الرئيسية للصنف");
    $("#unit_id").focus();
    return false;
   }
  
    var unit_id=$("#retail_units_id").val();
    if(unit_id==""){
  
     alert(" فضلك اختر وحده  التجزئة  للصنف الرئيسي");
     $("#retail_units_id").focus();
     return false;
    }

    var retail_unit_quntToParent=$("#retail_unit_quntToParent").val();
    if(retail_unit_quntToParent=="" || retail_unit_quntToParent==0){
     alert("من فضلك ادخل عدد وحدات الوحده التجزئة بالنسبة للأب");
     $("#retail_unit_quntToParent").focus();
     return false;
    }

   //}

   var price=$("#price").val();
   if(price==""){
    alert("من فضلك  ادخل السعر التجزئة للوحده الرئيسية   ");
    $("#price").focus();
    return false;
   }

  
   var gomla_price=$("#gomla_price").val();
   if(gomla_price==""){
    alert("من فضلك  ادخل السعر  الجملة للوحده الرئيسية   ");
    $("#gomla_price").focus();
    return false;
   }
   
   var cost_price=$("#cost_price").val();
   if(cost_price==""){
    alert("من فضلك  ادخل    سعر تكلفة الشراء للوحدة الرئيسية   ");
    $("#cost_price").focus();
    return false;
   }
var price_retail=$("#price_retail").val();
if(price_retail==""){
 alert("من فضلك  ادخل السعر  للوحده التجزئة   ");
 $("#price_retail").focus();
 return false;
}


   var active=$("#active").val();
   if(active==""){
    alert("من فضلك اختر حالة تفعيل الصنف     ");
    $("#has_fixced_price").focus();
    return false;
   }

  });



  $(document).on('click','#do_edit_item_cardd',function(e){

    var barcode=$("#barcode").val();
    if(barcode==""){
     alert("من فضلك ادخل باركود الصنف");
     $("#barcode").focus();
     return false;
    }


    var name=$("#name").val();
    if(name==""){
     alert("من فضلك ادخل اسم الصنف");
     $("#name").focus();
     return false;
    }
 
    var item_type=$("#item_type").val();
    if(item_type==""){
     alert("من فضلك ادخل نوع الصنف");
     $("#item_type").focus();
     return false;
    }
 
    var items_categories_id=$("#items_categories_id").val();
    if(items_categories_id==""){
     alert("من فضلك اختر فئة الصنف");
     $("#items_categories_id").focus();
     return false;
    }
 
    var unit_id=$("#unit_id").val();
    if(unit_id==""){
     alert("من فضلك اختر وحده القياس الاب للصنف");
     $("#unit_id").focus();
     return false;
    }
    
 
    
     var unit_id=$("#retail_units_id").val();
     if(unit_id==""){
   
      alert("من فضلك اختر وحده التجزئة للصنف");
      $("#unit_id").focus();
      return false;
     }
 
     var retail_unit_quntToParent=$("#retail_unit_quntToParent").val();
     if(retail_unit_quntToParent=="" || retail_unit_quntToParent==0){
      alert("من فضلك ادخل عدد وحدات الوحده التجزئة بالنسبة للوحدة الرئيسية");
      $("#retail_unit_quntToParent").focus();
      return false;
     }
    var cost_price=$("#cost_price").val();
    if(cost_price==""){
     alert("من فضلك  ادخل    سعر تكلفة الشراء للوحدة الرئيسية   ");
     $("#cost_price").focus();
     return false;
    }
 
  
 
    var active=$("#active").val();
    if(active==""){
     alert("من فضلك اختر حالة تفعيل الصنف     ");
     $("#active").focus();
     return false;
    }
 
   });

   $(document).on('input','#search_by_text',function(e){
    make_search();
  });

   $(document).on('change','#item_type_search',function(e){
    make_search();
  });
  
  $(document).on('change','#items_categories_id_search',function(e){
    make_search();
  });

  $('input[type=radio][name=searchbyradio]').change(function() {

    make_search();
  });



  function make_search(){
    var search_by_text=$("#search_by_text").val();
    var item_type=$("#item_type_search").val();
    var items_categories_id=$("#items_categories_id_search").val();
    var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
    var token_search=$("#token_search").val();
    var ajax_search_url=$("#ajax_search_url").val();
    
    jQuery.ajax({
      url:ajax_search_url,
      type:'post',
      dataType:'html',
      cache:false,
      data:{search_by_text:search_by_text,item_type:item_type,items_categories_id:items_categories_id,"_token":token_search,searchbyradio:searchbyradio},
      success:function(data){
     
       $("#ajax_responce_serarchDiv").html(data);
      },
      error:function(){
    
      }
    });
    
  }
  
  $(document).on('click','#ajax_pagination_in_search',function(e){
    e.preventDefault();
    var search_by_text=$("#search_by_text").val();
    var item_type=$("#item_type_search").val();
    var items_categories_id=$("#items_categories_id_search").val();
    var searchbyradio=$("input[type=radio][name=searchbyradio]:checked").val();
    var token_search=$("#token_search").val();
    
    var url=$(this).attr("href");
    
    jQuery.ajax({
      url:url,
      type:'post',
      dataType:'html',
      cache:false,
      data:{search_by_text:search_by_text,item_type:item_type,items_categories_id:items_categories_id,"_token":token_search,searchbyradio:searchbyradio},
      success:function(data){
     
       $("#ajax_responce_serarchDiv").html(data);
      },
      error:function(){
    
      }
    });
    
    
    
    });





    function make_search_movements(){
      var store_id=$("#store_id_move_search").val();
      var movements_categories=$("#movements_categoriesMoveSearch").val();
      var movements_types=$("#movements_typesMoveSearch").val();
      var from_date=$("#from_date_moveSearch").val();
      var to_date=$("#to_date_moveSearch").val();
      var moveDateorderType=$("#moveDateorderType").val();
      var token_search=$("#token_search").val();
      var ajax_search_url=$("#ajax_search_movements").val();
    
      jQuery.ajax({
        url:ajax_search_url,
        type:'post',
        dataType:'html',
        cache:false,
        data:{store_id:store_id,movements_categories:movements_categories,movements_types:movements_types,
          from_date:from_date,to_date:to_date
          ,"_token":token_search,moveDateorderType:moveDateorderType},
        success:function(data){
       
         $("#ajaxSearchMovementsDiv").html(data);
        },
        error:function(){
      
        }
      });
      
    }

    $(document).on('click','#ajax_pagination_in_searchMovements ',function(e){
      e.preventDefault();
      var store_id=$("#store_id_move_search").val();
      var movements_categories=$("#movements_categoriesMoveSearch").val();
      var movements_types=$("#movements_typesMoveSearch").val();
      var from_date=$("#from_date_moveSearch").val();
      var to_date=$("#to_date_moveSearch").val();
      var moveDateorderType=$("#moveDateorderType").val();
      var token_search=$("#token_search").val();
      var ajax_search_url=$("#ajax_search_movements").val();
    
      var token_search=$("#token_search").val();
      
      var url=$(this).attr("href");
      
      jQuery.ajax({
        url:ajax_search_url,
        type:'post',
        dataType:'html',
        cache:false,
        data:{store_id:store_id,movements_categories:movements_categories,movements_types:movements_types,
          from_date:from_date,to_date:to_date
          ,"_token":token_search,moveDateorderType:moveDateorderType},
        success:function(data){
       
         $("#ajaxSearchMovementsDiv").html(data);
        },
        error:function(){
      
        }
      });
      
      
      
      });
  
      
      $(document).on('click','#ShowMovementsBtn',function(e){
        make_search_movements();
      });
    $(document).on('change','#store_id_move_search',function(e){
      make_search_movements();
    });
    $(document).on('change','#movements_categoriesMoveSearch',function(e){
      make_search_movements();
    });
  
    $(document).on('change','#movements_typesMoveSearch',function(e){
      make_search_movements();
    });
  
    $(document).on('change','#from_date_moveSearch',function(e){
      make_search_movements();
    });
  
    $(document).on('change','#to_date_moveSearch',function(e){
      make_search_movements();
    });
    $(document).on('change','#moveDateorderType',function(e){
      make_search_movements();
    });
  


});