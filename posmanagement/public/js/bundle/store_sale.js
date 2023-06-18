(window.webpackJsonp=window.webpackJsonp||[]).push([[81],{1129:function(t,e,a){"use strict";a.r(e);var i=a(6),s=a.n(i),n=a(4),r=a(0),o=a.n(r),l=a(66);function d(t,e,a,i,s,n,r){try{var o=t[n](r),l=o.value}catch(t){return void a(t)}o.done?e(l):Promise.resolve(l).then(i,s)}function u(t){return function(){var e=this,a=arguments;return new Promise((function(i,s){var n=t.apply(e,a);function r(t){d(n,i,s,r,o,"next",t)}function o(t){d(n,i,s,r,o,"throw",t)}r(void 0)}))}}function c(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,i)}return a}function _(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}var p={metaInfo:{title:"Create Sale"},data:function(){var t;return _(t={focused:!1,timer:null,search_input:"",product_filter:[],stripe_key:"",stripe:{},cardElement:{},paymentProcessing:!1,isLoading:!0,warehouses:[],clients:[],client:{},products:[],details:[],detail:{},sales:[],payment:{status:"pending",Reglement:"Cash",amount:"",received_amount:""},sale:{id:"",date:(new Date).toISOString().slice(0,10),statut:"completed",notes:"",client_id:"",warehouse_id:"",tax_rate:0,TaxNet:0,shipping:0,discount:0}},"timer",null),_(t,"total",0),_(t,"GrandTotal",0),_(t,"units",[]),_(t,"product",{id:"",code:"",stock:"",quantity:1,discount:"",DiscountNet:"",discount_Method:"",name:"",sale_unit_id:"",fix_stock:"",fix_price:"",unitSale:"",Net_price:"",Unit_price:"",Total_price:"",subtotal:"",product_id:"",detail_id:"",taxe:"",tax_percent:"",tax_method:"",product_variant_id:""}),t},computed:function(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?c(Object(a),!0).forEach((function(e){_(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):c(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}({},Object(n.c)(["currentUser"])),methods:{loadStripe_payment:function(){var t=this;return u(s.a.mark((function e(){var a;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(l.a)("".concat(t.stripe_key));case 2:t.stripe=e.sent,a=t.stripe.elements(),t.cardElement=a.create("card",{classes:{base:"bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out"}}),t.cardElement.mount("#card-element");case 6:case"end":return e.stop()}}),e)})))()},handleFocus:function(){this.focused=!0},handleBlur:function(){this.focused=!1},Selected_PaymentMethod:function(t){var e=this;"credit card"==t&&setTimeout((function(){e.loadStripe_payment()}),500)},Selected_PaymentStatus:function(t){if("paid"==t){var e=this.GrandTotal.toFixed(2);this.payment.amount=this.formatNumber(e,2),this.payment.received_amount=this.formatNumber(e,2)}else this.payment.amount=0,this.payment.received_amount=0},Verified_paidAmount:function(){isNaN(this.payment.amount)?this.payment.amount=0:this.payment.amount>this.payment.received_amount?(this.makeToast("warning",this.$t("Paying_amount_is_greater_than_Received_amount"),this.$t("Warning")),this.payment.amount=0):this.payment.amount>this.GrandTotal&&(this.makeToast("warning",this.$t("Paying_amount_is_greater_than_Grand_Total"),this.$t("Warning")),this.payment.amount=0)},Verified_Received_Amount:function(){isNaN(this.payment.received_amount)&&(this.payment.received_amount=0)},Submit_Sale:function(){var t=this;this.$refs.create_sale.validate().then((function(e){e?t.payment.amount>t.payment.received_amount?(t.makeToast("warning",t.$t("Paying_amount_is_greater_than_Received_amount"),t.$t("Warning")),t.payment.received_amount=0):t.payment.amount>t.GrandTotal?(t.makeToast("warning",t.$t("Paying_amount_is_greater_than_Grand_Total"),t.$t("Warning")),t.payment.amount=0):t.Create_Sale():t.makeToast("danger",t.$t("Please_fill_the_form_correctly"),t.$t("Failed"))}))},submit_Update_Detail:function(){var t=this;this.$refs.Update_Detail.validate().then((function(e){e&&t.Update_Detail()}))},getValidationState:function(t){var e=t.dirty,a=t.validated,i=t.valid;return e||a?void 0===i?null:i:null},makeToast:function(t,e,a){this.$root.$bvToast.toast(e,{title:a,variant:t,solid:!0})},Get_sales_units:function(t){var e=this;axios.get("Get_sales_units?id="+t).then((function(t){var a=t.data;return e.units=a}))},Modal_Updat_Detail:function(t){this.detail={},this.Get_sales_units(t.product_id),this.detail.detail_id=t.detail_id,this.detail.sale_unit_id=t.sale_unit_id,this.detail.name=t.name,this.detail.Unit_price=t.Unit_price,this.detail.fix_price=t.fix_price,this.detail.fix_stock=t.fix_stock,this.detail.stock=t.stock,this.detail.tax_method=t.tax_method,this.detail.discount_Method=t.discount_Method,this.detail.discount=t.discount,this.detail.quantity=t.quantity,this.detail.tax_percent=t.tax_percent,this.$bvModal.show("form_Update_Detail")},Update_Detail:function(){for(var t=0;t<this.details.length;t++)if(this.details[t].detail_id===this.detail.detail_id){for(var e=0;e<this.units.length;e++)this.units[e].id==this.detail.sale_unit_id&&("/"==this.units[e].operator?(this.details[t].stock=this.detail.fix_stock*this.units[e].operator_value,this.details[t].unitSale=this.units[e].ShortName):(this.details[t].stock=this.detail.fix_stock/this.units[e].operator_value,this.details[t].unitSale=this.units[e].ShortName));this.details[t].stock<this.details[t].quantity?this.details[t].quantity=this.details[t].stock:this.details[t].quantity=1,this.details[t].Unit_price=this.detail.Unit_price,this.details[t].tax_percent=this.detail.tax_percent,this.details[t].tax_method=this.detail.tax_method,this.details[t].discount_Method=this.detail.discount_Method,this.details[t].discount=this.detail.discount,this.details[t].sale_unit_id=this.detail.sale_unit_id,"2"==this.details[t].discount_Method?this.details[t].DiscountNet=this.details[t].discount:this.details[t].DiscountNet=parseFloat(this.details[t].Unit_price*this.details[t].discount/100),"1"==this.details[t].tax_method?(this.details[t].Net_price=parseFloat(this.details[t].Unit_price-this.details[t].DiscountNet),this.details[t].taxe=parseFloat(this.details[t].tax_percent*(this.details[t].Unit_price-this.details[t].DiscountNet)/100)):(this.details[t].Net_price=parseFloat((this.details[t].Unit_price-this.details[t].DiscountNet)/(this.details[t].tax_percent/100+1)),this.details[t].taxe=parseFloat(this.details[t].Unit_price-this.details[t].Net_price-this.details[t].DiscountNet)),this.$forceUpdate()}this.Calcul_Total(),this.$bvModal.hide("form_Update_Detail")},search:function(){var t=this;if(this.timer&&(clearTimeout(this.timer),this.timer=null),this.search_input.length<1)return this.product_filter=[];""!=this.sale.warehouse_id&&null!=this.sale.warehouse_id?this.timer=setTimeout((function(){var e=t.products.filter((function(e){return e.code===t.search_input||e.barcode.includes(t.search_input)}));1===e.length?t.SearchProduct(e[0]):t.product_filter=t.products.filter((function(e){return e.name.toLowerCase().startsWith(t.search_input.toLowerCase())||e.code.toLowerCase().startsWith(t.search_input.toLowerCase())||e.barcode.toLowerCase().startsWith(t.search_input.toLowerCase())}))}),800):this.makeToast("warning",this.$t("SelectWarehouse"),this.$t("Warning"))},getResultValue:function(t){return t.code+" ("+t.name+")"},SearchProduct:function(t){this.product={},this.details.length>0&&this.details.some((function(e){return e.code===t.code}))?this.makeToast("warning",this.$t("AlreadyAdd"),this.$t("Warning")):(this.product.code=t.code,this.product.stock=t.qte_sale,this.product.fix_stock=t.qte,t.qte_sale<1?this.product.quantity=t.qte_sale:this.product.quantity=1,this.product.product_variant_id=t.product_variant_id,this.Get_Product_Details(t.id)),this.search_input="",this.product_filter=[]},Selected_Warehouse:function(t){this.search_input="",this.product_filter=[],this.Get_Products_By_Warehouse(t)},Get_Products_By_Warehouse:function(t){var e=this;o.a.start(),o.a.set(.1),axios.get("Products/Warehouse/"+t+"?stock=1").then((function(t){e.products=t.data,o.a.done()})).catch((function(t){}))},add_product:function(){this.details.length>0?this.Last_Detail_id():0===this.details.length&&(this.product.detail_id=1),this.details.push(this.product)},Verified_Qty:function(t,e){for(var a=0;a<this.details.length;a++)this.details[a].detail_id===e&&(isNaN(t.quantity)&&(this.details[a].quantity=t.stock),t.quantity>t.stock?(this.makeToast("warning",this.$t("LowStock"),this.$t("Warning")),this.details[a].quantity=t.stock):this.details[a].quantity=t.quantity);this.$forceUpdate(),this.Calcul_Total()},increment:function(t,e){for(var a=0;a<this.details.length;a++)this.details[a].detail_id==e&&(t.quantity+1>t.stock?this.makeToast("warning",this.$t("LowStock"),this.$t("Warning")):this.formatNumber(this.details[a].quantity++,2));this.$forceUpdate(),this.Calcul_Total()},decrement:function(t,e){for(var a=0;a<this.details.length;a++)this.details[a].detail_id==e&&t.quantity-1>0&&(t.quantity-1>t.stock?this.makeToast("warning",this.$t("LowStock"),this.$t("Warning")):this.formatNumber(this.details[a].quantity--,2));this.$forceUpdate(),this.Calcul_Total()},formatNumber:function(t,e){var a=("string"==typeof t?t:t.toString()).split(".");if(e<=0)return a[0];var i=a[1]||"";if(i.length>e)return"".concat(a[0],".").concat(i.substr(0,e));for(;i.length<e;)i+="0";return"".concat(a[0],".").concat(i)},Calcul_Total:function(){this.total=0;for(var t=0;t<this.details.length;t++){var e=this.details[t].taxe*this.details[t].quantity;this.details[t].subtotal=parseFloat(this.details[t].quantity*this.details[t].Net_price+e),this.total=parseFloat(this.total+this.details[t].subtotal)}var a=parseFloat(this.total-this.sale.discount);this.sale.TaxNet=parseFloat(a*this.sale.tax_rate/100),this.GrandTotal=parseFloat(a+this.sale.TaxNet+this.sale.shipping);var i=this.GrandTotal.toFixed(2);this.GrandTotal=parseFloat(i),"paid"==this.payment.status&&(this.payment.amount=this.formatNumber(this.GrandTotal,2))},delete_Product_Detail:function(t){for(var e=0;e<this.details.length;e++)t===this.details[e].detail_id&&(this.details.splice(e,1),this.Calcul_Total())},verifiedForm:function(){if(this.details.length<=0)return this.makeToast("warning",this.$t("AddProductToList"),this.$t("Warning")),!1;for(var t=0,e=0;e<this.details.length;e++)""!=this.details[e].quantity&&0!==this.details[e].quantity||(t+=1);return!(t>0)||(this.makeToast("warning",this.$t("AddQuantity"),this.$t("Warning")),!1)},keyup_OrderTax:function(){isNaN(this.sale.tax_rate)?this.sale.tax_rate=0:this.Calcul_Total()},keyup_Discount:function(){isNaN(this.sale.discount)?this.sale.discount=0:this.Calcul_Total()},keyup_Shipping:function(){isNaN(this.sale.shipping)?this.sale.shipping=0:this.Calcul_Total()},processPayment:function(){var t=this;return u(s.a.mark((function e(){var a,i;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.paymentProcessing=!0,e.next=3,t.stripe.createToken(t.cardElement);case 3:a=e.sent,i=a.token,a.error?(t.paymentProcessing=!1,o.a.done(),t.makeToast("danger",t.$t("InvalidData"),t.$t("Failed"))):axios.post("sales",{date:t.sale.date,client_id:t.sale.client_id,warehouse_id:t.sale.warehouse_id,statut:t.sale.statut,notes:t.sale.notes,tax_rate:t.sale.tax_rate,TaxNet:t.sale.TaxNet,discount:t.sale.discount,shipping:t.sale.shipping,GrandTotal:t.GrandTotal,details:t.details,payment:t.payment,amount:parseFloat(t.payment.amount).toFixed(2),received_amount:parseFloat(t.payment.received_amount).toFixed(2),change:parseFloat(t.payment.received_amount-t.payment.amount).toFixed(2),token:i.id}).then((function(e){t.paymentProcessing=!1,t.makeToast("success",t.$t("Create.TitleSale"),t.$t("Success")),o.a.done(),t.$router.push({name:"index_sales"})})).catch((function(e){t.paymentProcessing=!1,o.a.done(),t.makeToast("danger",t.$t("InvalidData"),t.$t("Failed"))}));case 7:case"end":return e.stop()}}),e)})))()},Create_Sale:function(){var t=this;this.verifiedForm()&&(o.a.start(),o.a.set(.1),"credit card"==this.payment.Reglement?""!=this.stripe_key?this.processPayment():(this.makeToast("danger",this.$t("credit_card_account_not_available"),this.$t("Failed")),o.a.done()):(this.paymentProcessing=!0,axios.post("sales",{date:this.sale.date,client_id:this.sale.client_id,warehouse_id:this.sale.warehouse_id,statut:this.sale.statut,notes:this.sale.notes,tax_rate:this.sale.tax_rate,TaxNet:this.sale.TaxNet,discount:this.sale.discount,shipping:this.sale.shipping,GrandTotal:this.GrandTotal,details:this.details,payment:this.payment,amount:parseFloat(this.payment.amount).toFixed(2),received_amount:parseFloat(this.payment.received_amount).toFixed(2),change:parseFloat(this.payment.received_amount-this.payment.amount).toFixed(2)}).then((function(e){t.makeToast("success",t.$t("Create.TitleSale"),t.$t("Success")),o.a.done(),t.paymentProcessing=!1,t.$router.push({name:"index_sales"})})).catch((function(e){o.a.done(),t.paymentProcessing=!1,t.makeToast("danger",t.$t("InvalidData"),t.$t("Failed"))}))))},Last_Detail_id:function(){this.product.detail_id=0;var t=this.details.length;this.product.detail_id=this.details[t-1].detail_id+1},Get_Product_Details:function(t){var e=this;axios.get("Products/"+t).then((function(t){e.product.discount=0,e.product.DiscountNet=0,e.product.discount_Method="2",e.product.product_id=t.data.id,e.product.name=t.data.name,e.product.Net_price=t.data.Net_price,e.product.Unit_price=t.data.Unit_price,e.product.taxe=t.data.tax_price,e.product.tax_method=t.data.tax_method,e.product.tax_percent=t.data.tax_percent,e.product.unitSale=t.data.unitSale,e.product.fix_price=t.data.fix_price,e.product.sale_unit_id=t.data.sale_unit_id,e.add_product(),e.Calcul_Total()}))},GetElements:function(){var t=this;axios.get("sales/create").then((function(e){t.clients=e.data.clients,t.warehouses=e.data.warehouses,t.stripe_key=e.data.stripe_key,t.isLoading=!1})).catch((function(e){setTimeout((function(){t.isLoading=!1}),500)}))}},created:function(){this.GetElements()}},m=a(2),h=Object(m.a)(p,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"main-content"},[a("breadcumb",{attrs:{page:t.$t("AddSale"),folder:t.$t("ListSales")}}),t._v(" "),t.isLoading?a("div",{staticClass:"loading_page spinner spinner-primary mr-3"}):t._e(),t._v(" "),t.isLoading?t._e():a("validation-observer",{ref:"create_sale"},[a("b-form",{on:{submit:function(e){return e.preventDefault(),t.Submit_Sale.apply(null,arguments)}}},[a("b-row",[a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("b-card",[a("b-row",[a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"date",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("date")}},[a("b-form-input",{attrs:{state:t.getValidationState(e),"aria-describedby":"date-feedback",type:"date"},model:{value:t.sale.date,callback:function(e){t.$set(t.sale,"date",e)},expression:"sale.date"}}),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"OrderTax-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,662910600)})],1),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"Customer",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("Customer")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),reduce:function(t){return t.value},placeholder:t.$t("Choose_Customer"),options:t.clients.map((function(t){return{label:t.name,value:t.id}}))},model:{value:t.sale.client_id,callback:function(e){t.$set(t.sale,"client_id",e)},expression:"sale.client_id"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}],null,!1,954232865)})],1),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"warehouse",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("warehouse")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),disabled:t.details.length>0,reduce:function(t){return t.value},placeholder:t.$t("Choose_Warehouse"),options:t.warehouses.map((function(t){return{label:t.name,value:t.id}}))},on:{input:t.Selected_Warehouse},model:{value:t.sale.warehouse_id,callback:function(e){t.$set(t.sale,"warehouse_id",e)},expression:"sale.warehouse_id"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}],null,!1,3317845931)})],1),t._v(" "),a("b-col",{staticClass:"mb-5",attrs:{md:"12"}},[a("h6",[t._v(t._s(t.$t("ProductName")))]),t._v(" "),a("div",{staticClass:"autocomplete",attrs:{id:"autocomplete"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.search_input,expression:"search_input"}],staticClass:"autocomplete-input",attrs:{placeholder:t.$t("Scan_Search_Product_by_Code_Name")},domProps:{value:t.search_input},on:{keyup:function(e){return t.search()},focus:t.handleFocus,blur:t.handleBlur,input:function(e){e.target.composing||(t.search_input=e.target.value)}}}),t._v(" "),a("ul",{directives:[{name:"show",rawName:"v-show",value:t.focused,expression:"focused"}],staticClass:"autocomplete-result-list"},t._l(t.product_filter,(function(e){return a("li",{staticClass:"autocomplete-result",on:{mousedown:function(a){return t.SearchProduct(e)}}},[t._v(t._s(t.getResultValue(e)))])})),0)])]),t._v(" "),a("b-col",{staticClass:"mb-4",attrs:{md:"12"}},[a("h5",[t._v(t._s(t.$t("order_products"))+" *")]),t._v(" "),a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table table-hover"},[a("thead",{staticClass:"bg-gray-300"},[a("tr",[a("th",{attrs:{scope:"col"}},[t._v("#")]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("ProductName")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("Net_Unit_Price")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("CurrentStock")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("Qty")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("Discount")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("Tax")))]),t._v(" "),a("th",{attrs:{scope:"col"}},[t._v(t._s(t.$t("SubTotal")))]),t._v(" "),a("th",{staticClass:"text-center",attrs:{scope:"col"}},[a("i",{staticClass:"i-Close-Window text-25"})])])]),t._v(" "),a("tbody",[t.details.length<=0?a("tr",[a("td",{attrs:{colspan:"9"}},[t._v(t._s(t.$t("NodataAvailable")))])]):t._e(),t._v(" "),t._l(t.details,(function(e){return a("tr",[a("td",[t._v(t._s(e.detail_id))]),t._v(" "),a("td",[a("span",[t._v(t._s(e.code))]),t._v(" "),a("br"),t._v(" "),a("span",{staticClass:"badge badge-success"},[t._v(t._s(e.name))]),t._v(" "),a("i",{staticClass:"i-Edit",on:{click:function(a){return t.Modal_Updat_Detail(e)}}})]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.formatNumber(e.Net_price,3)))]),t._v(" "),a("td",[a("span",{staticClass:"badge badge-outline-warning"},[t._v(t._s(e.stock)+" "+t._s(e.unitSale))])]),t._v(" "),a("td",[a("div",{staticClass:"quantity"},[a("b-input-group",[a("b-input-group-prepend",[a("span",{staticClass:"btn btn-primary btn-sm",on:{click:function(a){return t.decrement(e,e.detail_id)}}},[t._v("-")])]),t._v(" "),a("input",{directives:[{name:"model",rawName:"v-model.number",value:e.quantity,expression:"detail.quantity",modifiers:{number:!0}}],staticClass:"form-control",attrs:{min:0,max:e.stock},domProps:{value:e.quantity},on:{keyup:function(a){return t.Verified_Qty(e,e.detail_id)},input:function(a){a.target.composing||t.$set(e,"quantity",t._n(a.target.value))},blur:function(e){return t.$forceUpdate()}}}),t._v(" "),a("b-input-group-append",[a("span",{staticClass:"btn btn-primary btn-sm",on:{click:function(a){return t.increment(e,e.detail_id)}}},[t._v("+")])])],1)],1)]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.formatNumber(e.DiscountNet*e.quantity,2)))]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.formatNumber(e.taxe*e.quantity,2)))]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(e.subtotal.toFixed(2)))]),t._v(" "),a("td",[a("a",{staticClass:"btn btn-icon btn-sm",attrs:{title:"Delete"},on:{click:function(a){return t.delete_Product_Detail(e.detail_id)}}},[a("i",{staticClass:"i-Close-Window text-25 text-danger"})])])])}))],2)])])]),t._v(" "),a("div",{staticClass:"offset-md-9 col-md-3 mt-4"},[a("table",{staticClass:"table table-striped table-sm"},[a("tbody",[a("tr",[a("td",{staticClass:"bold"},[t._v(t._s(t.$t("OrderTax")))]),t._v(" "),a("td",[a("span",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.sale.TaxNet.toFixed(2))+" ("+t._s(t.formatNumber(t.sale.tax_rate,2))+" %)")])])]),t._v(" "),a("tr",[a("td",{staticClass:"bold"},[t._v(t._s(t.$t("Discount")))]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.sale.discount.toFixed(2)))])]),t._v(" "),a("tr",[a("td",{staticClass:"bold"},[t._v(t._s(t.$t("Shipping")))]),t._v(" "),a("td",[t._v(t._s(t.currentUser.currency)+" "+t._s(t.sale.shipping.toFixed(2)))])]),t._v(" "),a("tr",[a("td",[a("span",{staticClass:"font-weight-bold"},[t._v(t._s(t.$t("Total")))])]),t._v(" "),a("td",[a("span",{staticClass:"font-weight-bold"},[t._v(t._s(t.currentUser.currency)+" "+t._s(t.GrandTotal.toFixed(2)))])])])])])]),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"Order Tax",rules:{regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("OrderTax")}},[a("b-input-group",{attrs:{append:"%"}},[a("b-form-input",{attrs:{state:t.getValidationState(e),"aria-describedby":"OrderTax-feedback",label:"Order Tax"},on:{keyup:function(e){return t.keyup_OrderTax()}},model:{value:t.sale.tax_rate,callback:function(e){t.$set(t.sale,"tax_rate",t._n(e))},expression:"sale.tax_rate"}})],1),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"OrderTax-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,2557352802)})],1),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"Discount",rules:{regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("Discount")}},[a("b-input-group",{attrs:{append:t.currentUser.currency}},[a("b-form-input",{attrs:{state:t.getValidationState(e),"aria-describedby":"Discount-feedback",label:"Discount"},on:{keyup:function(e){return t.keyup_Discount()}},model:{value:t.sale.discount,callback:function(e){t.$set(t.sale,"discount",t._n(e))},expression:"sale.discount"}})],1),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Discount-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,1543927045)})],1),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"Shipping",rules:{regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("Shipping")}},[a("b-input-group",{attrs:{append:t.currentUser.currency}},[a("b-form-input",{attrs:{state:t.getValidationState(e),"aria-describedby":"Shipping-feedback",label:"Shipping"},on:{keyup:function(e){return t.keyup_Shipping()}},model:{value:t.sale.shipping,callback:function(e){t.$set(t.sale,"shipping",t._n(e))},expression:"sale.shipping"}})],1),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Shipping-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,1943903941)})],1),t._v(" "),a("b-col",{staticClass:"mb-3",attrs:{lg:"4",md:"4",sm:"12"}},[a("validation-provider",{attrs:{name:"Status",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("Status")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),reduce:function(t){return t.value},placeholder:t.$t("Choose_Status"),options:[{label:"completed",value:"completed"},{label:"Pending",value:"pending"},{label:"ordered",value:"ordered"}]},model:{value:t.sale.statut,callback:function(e){t.$set(t.sale,"statut",e)},expression:"sale.statut"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}],null,!1,3823911716)})],1),t._v(" "),a("b-col",{attrs:{md:"4"}},[a("validation-provider",{attrs:{name:"PaymentStatus"}},[a("b-form-group",{attrs:{label:t.$t("PaymentStatus")}},[a("v-select",{attrs:{reduce:function(t){return t.value},placeholder:t.$t("Choose_Status"),options:[{label:"Paid",value:"paid"},{label:"partial",value:"partial"},{label:"Pending",value:"pending"}]},on:{input:t.Selected_PaymentStatus},model:{value:t.payment.status,callback:function(e){t.$set(t.payment,"status",e)},expression:"payment.status"}})],1)],1)],1),t._v(" "),"pending"!=t.payment.status?a("b-col",{attrs:{md:"4"}},[a("validation-provider",{attrs:{name:"Payment choice",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("Paymentchoice")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),reduce:function(t){return t.value},placeholder:t.$t("PleaseSelect"),options:[{label:"Cash",value:"Cash"},{label:"credit card",value:"credit card"},{label:"cheque",value:"cheque"},{label:"Western Union",value:"Western Union"},{label:"bank transfer",value:"bank transfer"},{label:"other",value:"other"}]},on:{input:t.Selected_PaymentMethod},model:{value:t.payment.Reglement,callback:function(e){t.$set(t.payment,"Reglement",e)},expression:"payment.Reglement"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}],null,!1,1785580075)})],1):t._e(),t._v(" "),"pending"!=t.payment.status?a("b-col",{attrs:{md:"4"}},[a("validation-provider",{attrs:{name:"Received Amount",rules:{required:!0,regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("Received_Amount")}},[a("b-form-input",{attrs:{label:"Received_Amount",placeholder:t.$t("Received_Amount"),state:t.getValidationState(e),"aria-describedby":"Received_Amount-feedback"},on:{keyup:function(e){return t.Verified_Received_Amount(t.payment.received_amount)}},model:{value:t.payment.received_amount,callback:function(e){t.$set(t.payment,"received_amount",t._n(e))},expression:"payment.received_amount"}}),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Received_Amount-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,4284534162)})],1):t._e(),t._v(" "),"pending"!=t.payment.status?a("b-col",{attrs:{md:"4"}},[a("validation-provider",{attrs:{name:"Amount",rules:{required:!0,regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("Paying_Amount")}},[a("b-form-input",{attrs:{disabled:"paid"==t.payment.status,label:"Amount",placeholder:t.$t("Paying_Amount"),state:t.getValidationState(e),"aria-describedby":"Amount-feedback"},on:{keyup:function(e){return t.Verified_paidAmount(t.payment.amount)}},model:{value:t.payment.amount,callback:function(e){t.$set(t.payment,"amount",t._n(e))},expression:"payment.amount"}}),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Amount-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}],null,!1,3839335188)})],1):t._e(),t._v(" "),"pending"!=t.payment.status?a("b-col",{attrs:{md:"4"}},[a("label",[t._v(t._s(t.$t("Change"))+" :")]),t._v(" "),a("p",{staticClass:"change_amount"},[t._v(t._s(parseFloat(t.payment.received_amount-t.payment.amount).toFixed(2)))])]):t._e(),t._v(" "),"pending"!=t.payment.status&&"credit card"==t.payment.Reglement?a("b-col",{staticClass:"mt-3",attrs:{md:"12"}},[a("form",{attrs:{id:"payment-form"}},[a("label",{staticClass:"leading-7 text-sm text-gray-600",attrs:{for:"card-element"}},[t._v(t._s(t.$t("Credit_Card_Info")))]),t._v(" "),a("div",{attrs:{id:"card-element"}}),t._v(" "),a("div",{attrs:{id:"card-errors",role:"alert"}})])]):t._e(),t._v(" "),a("b-col",{staticClass:"mt-3",attrs:{md:"12"}},[a("b-form-group",{attrs:{label:t.$t("Note")}},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.sale.notes,expression:"sale.notes"}],staticClass:"form-control",attrs:{rows:"4",placeholder:t.$t("Afewwords")},domProps:{value:t.sale.notes},on:{input:function(e){e.target.composing||t.$set(t.sale,"notes",e.target.value)}}})])],1),t._v(" "),a("b-col",{attrs:{md:"12"}},[a("b-form-group",[a("b-button",{attrs:{variant:"primary",disabled:t.paymentProcessing},on:{click:t.Submit_Sale}},[t._v(t._s(t.$t("submit")))]),t._v(" "),t.paymentProcessing?t._m(0):t._e()],1)],1)],1)],1)],1)],1)],1)],1),t._v(" "),a("validation-observer",{ref:"Update_Detail"},[a("b-modal",{attrs:{"hide-footer":"",size:"md",id:"form_Update_Detail",title:t.detail.name}},[a("b-form",{on:{submit:function(e){return e.preventDefault(),t.submit_Update_Detail.apply(null,arguments)}}},[a("b-row",[a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Product Price",rules:{required:!0,regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("ProductPrice"),id:"Price-input"}},[a("b-form-input",{attrs:{label:"Product Price",state:t.getValidationState(e),"aria-describedby":"Price-feedback"},model:{value:t.detail.Unit_price,callback:function(e){t.$set(t.detail,"Unit_price",e)},expression:"detail.Unit_price"}}),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Price-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}])})],1),t._v(" "),a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Tax Method",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("TaxMethod")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),reduce:function(t){return t.value},placeholder:t.$t("Choose_Method"),options:[{label:"Exclusive",value:"1"},{label:"Inclusive",value:"2"}]},model:{value:t.detail.tax_method,callback:function(e){t.$set(t.detail,"tax_method",e)},expression:"detail.tax_method"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}])})],1),t._v(" "),a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Order Tax",rules:{required:!0,regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("OrderTax")}},[a("b-input-group",{attrs:{append:"%"}},[a("b-form-input",{attrs:{label:"Order Tax",state:t.getValidationState(e),"aria-describedby":"OrderTax-feedback"},model:{value:t.detail.tax_percent,callback:function(e){t.$set(t.detail,"tax_percent",e)},expression:"detail.tax_percent"}})],1),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"OrderTax-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}])})],1),t._v(" "),a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Discount Method",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("Discount_Method")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{reduce:function(t){return t.value},placeholder:t.$t("Choose_Method"),state:!s[0]&&(!!i||null),options:[{label:"Percent %",value:"1"},{label:"Fixed",value:"2"}]},model:{value:t.detail.discount_Method,callback:function(e){t.$set(t.detail,"discount_Method",e)},expression:"detail.discount_Method"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}])})],1),t._v(" "),a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Discount Rate",rules:{required:!0,regex:/^\d*\.?\d*$/}},scopedSlots:t._u([{key:"default",fn:function(e){return[a("b-form-group",{attrs:{label:t.$t("Discount")}},[a("b-form-input",{attrs:{label:"Discount",state:t.getValidationState(e),"aria-describedby":"Discount-feedback"},model:{value:t.detail.discount,callback:function(e){t.$set(t.detail,"discount",t._n(e))},expression:"detail.discount"}}),t._v(" "),a("b-form-invalid-feedback",{attrs:{id:"Discount-feedback"}},[t._v(t._s(e.errors[0]))])],1)]}}])})],1),t._v(" "),a("b-col",{attrs:{lg:"12",md:"12",sm:"12"}},[a("validation-provider",{attrs:{name:"Unit Sale",rules:{required:!0}},scopedSlots:t._u([{key:"default",fn:function(e){var i=e.valid,s=e.errors;return a("b-form-group",{attrs:{label:t.$t("UnitSale")}},[a("v-select",{class:{"is-invalid":!!s.length},attrs:{state:!s[0]&&(!!i||null),placeholder:t.$t("Choose_Unit_Sale"),reduce:function(t){return t.value},options:t.units.map((function(t){return{label:t.name,value:t.id}}))},model:{value:t.detail.sale_unit_id,callback:function(e){t.$set(t.detail,"sale_unit_id",e)},expression:"detail.sale_unit_id"}}),t._v(" "),a("b-form-invalid-feedback",[t._v(t._s(s[0]))])],1)}}])})],1),t._v(" "),a("b-col",{attrs:{md:"12"}},[a("b-form-group",[a("b-button",{attrs:{variant:"primary",type:"submit",disabled:t.paymentProcessing}},[t._v(t._s(t.$t("submit")))]),t._v(" "),t.paymentProcessing?t._m(1):t._e()],1)],1)],1)],1)],1)],1)],1)}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"typo__p"},[e("div",{staticClass:"spinner sm spinner-primary mt-3"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"typo__p"},[e("div",{staticClass:"spinner sm spinner-primary mt-3"})])}],!1,null,null,null);e.default=h.exports},66:function(t,e,a){"use strict";a.d(e,"a",(function(){return c}));var i="https://js.stripe.com/v3",s=/^https:\/\/js\.stripe\.com\/v3\/?(\?.*)?$/,n="loadStripe.setLoadParameters was called but an existing Stripe.js script already exists in the document; existing script parameters will be used",r=null,o=function(t){return null!==r?r:r=new Promise((function(e,a){if("undefined"!=typeof window)if(window.Stripe&&t&&console.warn(n),window.Stripe)e(window.Stripe);else try{var r=function(){for(var t=document.querySelectorAll('script[src^="'.concat(i,'"]')),e=0;e<t.length;e++){var a=t[e];if(s.test(a.src))return a}return null}();r&&t?console.warn(n):r||(r=function(t){var e=t&&!t.advancedFraudSignals?"?advancedFraudSignals=false":"",a=document.createElement("script");a.src="".concat(i).concat(e);var s=document.head||document.body;if(!s)throw new Error("Expected document.body not to be null. Stripe.js requires a <body> element.");return s.appendChild(a),a}(t)),r.addEventListener("load",(function(){window.Stripe?e(window.Stripe):a(new Error("Stripe.js not available"))})),r.addEventListener("error",(function(){a(new Error("Failed to load Stripe.js"))}))}catch(t){return void a(t)}else e(null)}))},l=function(t,e,a){if(null===t)return null;var i=t.apply(void 0,e);return function(t,e){t&&t._registerWrapper&&t._registerWrapper({name:"stripe-js",version:"1.18.0",startTime:e})}(i,a),i},d=Promise.resolve().then((function(){return o(null)})),u=!1;d.catch((function(t){u||console.warn(t)}));var c=function(){for(var t=arguments.length,e=new Array(t),a=0;a<t;a++)e[a]=arguments[a];u=!0;var i=Date.now();return d.then((function(t){return l(t,e,i)}))}}}]);