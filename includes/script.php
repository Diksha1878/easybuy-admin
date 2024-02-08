<script>
	function get_cat(id)
	{
		
		
		$.ajax({
			type:"post",
			url:"ajax/get_subcat.php",
			data:{
				table:'cats',
				id:id
			},
			success:function (res)
			{
				//alert(res);
				//console.log(res);
				$("#cat").html(res);
				
			}
			
		});
	}
	function get_subcat(id)
	{
		
		
		$.ajax({
			type:"post",
			url:"ajax/get_subcat.php",
			data:{table:'subcats',  id:id},
			success:function (res)
			{
				//console.log(res);
				$("#subcat").html(res);
				
			}
			
		});
	}
	function get_brand(id)
	{
		
		
		$.ajax({
			type:"post",
			url:"ajax/get_subcat.php",
			data:{table:'brands',  id:id},
			success:function (res)
			{
				//alert(res);
				//console.log(res);
				$("#brand").html(res);
				
			}
			
		});
	}
	function showdimension(id,index){
		
		if(id==1){
			$("#dimension"+index).show();
		}
		else{
			$("#dimension"+index).hide();	
		}
	}
	
	function setsaleprice(price,index){ 
		
		var mrp = parseInt(price);
		$("#price"+index).attr("max",(mrp-1));
		
	}
	function setcomboprice(price,mrp,index){ 
		$(".help_price"+index).html('');
		$("#price"+index).css("border","");
		if(parseInt(price)>=parseInt(mrp)){
			$("#price"+index).css("border","solid 1px #f00");
			$(".help_price"+index).html("<span>You shouldn't Enter Sale Price Greater than MRP</span>").css("color","#f00");
		}
		var saleprice = parseInt(price);
		$("#combo_price"+index).attr("max",(saleprice-1));
		
	}
	function setcombowarning(price,sale_price,index){
		$(".help_comboprice"+index).html('');
		$("#combo_price"+index).css("border","");
		if(parseInt(price)>=parseInt(sale_price)){
			$("#combo_price"+index).css("border","solid 1px #f00");
			$(".help_comboprice"+index).html("<span>You shouldn't Enter Sale Price Greater Other Price</span>").css("color","#f00");
		}
	}
	function addtopproduct(index,id, e){
	    e.preventDefault();
	    e.stopPropagation();
		$.ajax({
			type:'post',
			data:{id:id},
			url:'ajax/set_top_product.php',
			success:function(result){
			    
			    if(result == 1){
			        $(e.target).text('Remove Top Product (Added)')
			    }
			    else if(result == 2){
			        $(e.target).text('Add to Top Product (Removed)')
			    }
			
				// window.location.reload();
				
			}
		});
	}
	function addnewarrival(index,id,e){
	    e.preventDefault();
	    e.stopPropagation();
		$.ajax({
			type:'post',
			data:{id:id},
			url:'ajax/set_new_arrival.php',
			success:function(result){
				
				// window.location.reload();
				 if(result == 1){
			        $(e.target).text('Remove New Arrival (Added)')
			    }
			    else if(result == 2){
			        $(e.target).text('Add to New Arrival (Removed)')
			    }
				
			}
		});
	}
	function setproducttype(type){
		$.ajax({
			type:'post',
			data:{type:type},
			url:'ajax/setproduct_type.php',
			success:function(result){
				//alert(result);
				}
			});
		}
	
</script>
