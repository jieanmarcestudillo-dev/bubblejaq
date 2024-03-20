document.onload = displayCart();
	function chooseSizes(array) {
		var obj = {
			id: array[0],
			name: array[1] + " - " + array[3],
			price: array[2],
			qty: 1
		};
		$.ajax({
			url: 'checkProduct.php',
			type: 'POST',
			dataType: 'json',
			data: {
				product: obj,
			},
		})
		.done(function(response) {
			response.forEach(function(product) {
				$('tr.productItem').each(function() {
					const productId = $(this).data('product-id');
					const qtyRemain = product.quantity;
					const productQty = $(this).find($('.productQty')).val();
					if (productId === obj.id) {
						if (parseInt(productQty) >= parseInt(qtyRemain)) {
							Swal.fire({
								title: "Insufficient Quantity",
								text: "Sorry, the product quantity is not enough",
								icon: "error"
							});
						} else {
							let cart = [];
							if (localStorage.getItem('cart')) {
								cart = JSON.parse(localStorage.getItem('cart'));
							}
							let found = false;
							for (let i = 0; i < cart.length; i++) {
								if (obj.id == cart[i].id) {
									cart[i].qty++;
									found = true;
									break;
								}
							}
							if (!found) {
								cart.push(obj);
							}
							localStorage.setItem('cart', JSON.stringify(cart));
							$("#addToCartModal").modal("hide");
							displayCart();
						}
					}
				});
			});

			let cart = [];
			if (localStorage.getItem('cart')) {
				cart = JSON.parse(localStorage.getItem('cart'));
			}
			let found = false;
			for (let i = 0; i < cart.length; i++) {
				if (obj.id == cart[i].id) {
					found = true;
					break;
				}
			}
			if (!found) {
				cart.push(obj);
			}
			localStorage.setItem('cart', JSON.stringify(cart));
			$("#addToCartModal").modal("hide");
			displayCart();
		});
	}

	function addToCart(id) {
		$.ajax({
			url: 'fetchProduct.php',
			type: 'POST',
			dataType: 'json',
			data: { prodId: id },
		})
		.done(function (response) {
			$("#addToCartModal").modal("show");
			var productContainer = document.getElementById('product-container');
			productContainer.innerHTML = '';
			for (var i = 0; i < response.length; i++) {
				var product = response[i];
				var button = $('<button>');
				button.addClass('btn rounded-0 mx-2 my-2');
				button.css({'color': '#F48C06', 'border':'1px solid #F48C06'});
				if(product.quantity != 0){
					button.attr('onclick', `chooseSizes([${product.id}, '${product.name}', ${product.sale_price}, '${product.item_size}'])`);
				}else{
					button.prop('disabled', true);
					button.css("text-decoration", "line-through");
				}
				var sizeName = '';
				switch (product.item_size) {
					case 'S':
						sizeName = 'SMALL';
						break;
					case 'M':
						sizeName = 'MEDIUM';
						break;
					case 'L':
						sizeName = 'LARGE';
						break;
					case 'XL':
						sizeName = 'EXTRA LARGE';
						break;
			
					default:
						sizeName = product.item_size; 
				}
				button.text(sizeName);
				$('#product-container').append(button);
			}
		});
	}

	function increaseOrder(id,name,price){
		let obj = {
			id : id,
			name : name,
			price : price,
			qty : 1
		}

		if(localStorage.getItem('cart') == null){
			let item = [obj];
			localStorage.setItem('cart', JSON.stringify(item));
		}else{
			//check if item already exist in the storage
			let item = JSON.parse(localStorage.getItem('cart'));
			let found = false;
			for(let x = 0; x < item.length; x++){
				if(obj.id == item[x].id){
					item[x].qty++;
					found = true;
					break;
				}
			}
			//if no match has been found
			if(!found){
				item.push(obj);
			}	
			localStorage.setItem('cart', JSON.stringify(item));
		}
		displayCart();
	}

	function decreaseOrder(id, name, price){
		let obj = {
			id : id,
			name : name,
			price : price,
			qty : 1
		}
		if(localStorage.getItem('cart') == null){
			//do nothing
		}else{
			//check if item already exist in the storage
			let item = JSON.parse(localStorage.getItem('cart'));
			let found = false;

			for(let x = 0; x < item.length; x++){
				if(obj.id == item[x].id){
					if(item[x].qty > 1){
						item[x].qty--;
					}else{
						item.splice(x,1);
					}
					found = true;
					break;
				}
			}

			localStorage.setItem('cart', JSON.stringify(item));
		}
		displayCart();
	}

	function displayCart() {
		let data = '';
		if (localStorage.getItem('cart')) {
		let item = JSON.parse(localStorage.getItem('cart'));
		let salesTb = document.getElementById('tableSales');
		let totalTag = document.getElementById('totalValue');
		let data = '';
		let total = 0;
		let subtotal = 0;
		if (item.length > 0) {		
			for (let x = 0; x < item.length; x++) {
			subtotal = item[x].price * item[x].qty;
			data += `
			<tr class='productItem' data-product-id="${item[x].id}">
				<td class='col-1'>${x + 1} </td>
				<td class='col-3'>${item[x].name}</td>
				<td class='col-2'><input class='form-control form-control-sm rounded-0 text-center productQty' min='1' onchange='changeQty(this.value, ${item[x].id})' type='number' value="${item[x].qty}"></td>
				<td class='col-1'>₱${item[x].price+'.00'}</td>
				<td class='col-2'>₱${subtotal+'.00'}</td>
				<td class='col-1'>
				<button class="btn btn-outline-danger rounded-0" onclick="removeItem(${item[x].id});"><i class="bi bi-trash"></i></button>
				</td>
			</tr>`;
			// <button class="btn btn-outline-secondary rounded-0" onclick="decreaseOrder(${item[x].id});"><i class="bi bi-dash"></i></button>
			// <button class="btn btn-outline-success rounded-0" onclick="increaseOrder(${item[x].id});"><i class="bi bi-plus"></i></button>
			total += item[x].price * item[x].qty;
			}
		} else {
			data += '<tr><td class="fw-bold text-uppercase py-3" colspan="6" style="font-size:12px; color:#F48C06">The cart is empty.</td></tr>';
		}
	
		salesTb.innerHTML = data;
		totalTag.innerHTML = total;
		}else{
			data += '<tr><td class="fw-bold text-uppercase py-3" colspan="6" style="font-size:12px; color:#F48C06">The cart is empty.</td></tr>';
		}
	}

	function changeQty(value, id, name, price) {
		let obj = {
			id: id,
			name: name,
			price: price,
			qty: value
		};
	
		$.ajax({
			url: 'checkProduct.php',
			type: 'POST',
			dataType: 'json',
			data: {
				product: obj,
			},
		})
		.done(function(response) {
			response.forEach(function(product) {
				$('tr.productItem').each(function() {
					const productId = $(this).data('product-id');
					const qtyRemain = product.quantity;
					const productQtyInput = $(this).find('.productQty'); 
					const productQty = parseInt(productQtyInput.val()); 
					if (productId === obj.id) {
						if (productQty > qtyRemain) {
							productQtyInput.val(qtyRemain);
							Swal.fire({
								title: "Insufficient Quantity",
								text: "Sorry, the product quantity is not enough",
								icon: "error"
							});
						} else {
							updateCart(obj);
						}
					}
				});
			});
		});
	}
	
	function updateCart(obj) {
		let item = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
		let found = false;
		for (let x = 0; x < item.length; x++) {
			if (obj.id == item[x].id) {
				item[x].qty = obj.qty;
				found = true;
				break;
			}
		}
		if (!found) {
			item.push(obj);
		}
		localStorage.setItem('cart', JSON.stringify(item));
		displayCart();
	}
	
	function calculate(value){
		let balance = document.getElementById('balance');
		document.getElementById('cash').value  =  value + '.00';
		let total = document.getElementById('totalValue').innerHTML;
		if(total == 0){		
			Swal.fire({
				position: 'center',
				icon: 'error',
				title: 'Your Cart is Empty',
				showConfirmButton: false,
				timer: 1500
			})
			document.getElementById('cash').value = "";
		}else{
			if(isNaN(value)){
				balance.innerHTML = 'NUMERIC VALUE ONLY!!!'
			}else{
				total = parseInt(value) - parseInt(total);
				if(total < 0){
					balance.innerHTML = 'CASH NOT ENOUGH';
				}else{
					balance.innerHTML = "₱" + total + ".00";
				}
			}
		}
	}

	function place_order(){
		if($('#balance').text() === 'CASH NOT ENOUGH'){
			Swal.fire({
				position: 'center',
				icon: 'error',
				title: 'Sorry, The cash is not enough',
				showConfirmButton: false,
				timer: 1500
			})
		}else{
			if (localStorage.getItem('cart') == null || localStorage.getItem('cart') == "" || localStorage.getItem('cart').length == 0) {
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: 'Sorry, Your  Cart is Empty',
					showConfirmButton: false,
					timer: 1500
				})
				return false;
			}else{
				if(document.getElementById('balance').textContent.trim() === "" || document.getElementById('balance').textContent.trim() === "₱NaN.00") {
					document.getElementById('cash').value = "";
					document.getElementById('balance').textContent = "";
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Please, Enter the Amount Rendered',
						showConfirmButton: false,
						timer: 1500
					})
					return false;
				}else{
					let changed = $('#balance').text();
					$.ajax({
						url:'sales_process.php',
						method:'post',
						data:{
							dataSent: localStorage.getItem('cart')
						},
						success:function(result){
						let timerInterval;
						Swal.fire({
						title: `The customer has changed ${changed}`,
						timer: 2500,
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading();
							const timer = Swal.getPopup().querySelector("b");
							timerInterval = setInterval(() => {
							timer.textContent = `${Swal.getTimerLeft()}`;
							}, 100);
						},
						willClose: () => {
							clearInterval(timerInterval);
						}
						}).then((result) => {
						if (result.dismiss === Swal.DismissReason.timer) {
							Swal.fire({
								title: 'Sales Submitted',
								text: "Sales has been submitted successfully",
								icon: 'success',
								position: 'center',
								showConfirmButton: false,
								timer: 1500,
							}).then((result) => {
							if (result) {
								location.reload();
								localStorage.clear()
								localStorage.removeItem(cart);
								displayCart();
							}
							});
						}
						});
						}
					})
				}
			}
		}
	}

	function removeItem(id) {
		if (localStorage.getItem('cart') != null) {
			Swal.fire({
				title: 'Are you sure?',
				text: "Do you want to remove this?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#F48C06',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, remove it!'
				}).then((result) => {
				if (result.isConfirmed) {
					let item = JSON.parse(localStorage.getItem('cart'));
					let foundIndex = -1;
					for (let x = 0; x < item.length; x++) {
						if (id == item[x].id) {
							foundIndex = x;
							break;
						}
					}
					if (foundIndex !== -1) {
						item.splice(foundIndex, 1);
						localStorage.setItem('cart', JSON.stringify(item));
						displayCart();
					}
				}
			})
		}
	}

	function clickFilter(){
		document.getElementById('filterBtn').click();
	}

	function removeAllItems() {
		if (localStorage.getItem('cart') === JSON.stringify([])) {
			return false;
		}else{
			Swal.fire({
				title: 'Are you sure?',
				text: "Do you want to clear the cart?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#F48C06',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, clear it!'
				}).then((result) => {
				if (result.isConfirmed) {
					let item = JSON.parse(localStorage.getItem('cart'));
					item.splice(0, item.length); 
					localStorage.setItem('cart', JSON.stringify(item)); 
					$("#cash").val('');
					$($('#balance')).empty()
					displayCart();
				}
			})
		}
	}

	$(document).ready(function(){
		$("#searchProduct").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			var products = $("#productOutput .col-4");
			products.filter(function() {
			var isMatch = $(this).text().toLowerCase().indexOf(value) > -1;
			$(this).toggle(isMatch);
			});
			var noResults = products.filter(":visible").length === 0;
			return noResults ? $("#noResultsMessage").removeClass("d-none").addClass("d-block") : $("#noResultsMessage").addClass("d-none").removeClass("d-block");
		});
	});