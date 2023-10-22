import Vue from "vue";
import store from "./store";
import Router from "vue-router";
import { i18n } from "./plugins/i18n";
import authenticate from "./auth/authenticate";
import IsConnected from "./auth/IsConnected";

import NProgress from "nprogress";

Vue.use(Router);

// create new router

const routes = [
    {
        path: "/",
        component: () => import("./views/app"),
        // beforeEnter: authenticate,
        redirect: "/app/dashboard",

        children: [
            {
                path: "/app/dashboard",
                name: "dashboard",
                component: () =>
                    import(
                        /* webpackChunkName: "dashboard" */ "./views/app/dashboard/dashboard"
                    ),
            },

            //Forms
            {
                path: "/app/forms",
                component: () =>
                    import(
                        /* webpackChunkName: "forms" */ "./views/app/pages/forms"
                    ),
                redirect: "app/forms/list",
                children: [
                    {
                        name: "index_forms",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_forms" */ "./views/app/pages/forms/index_forms"
                            ),
                    },

                    {
                        path: "detail/:id",
                        name: "detail_form",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_form" */ "./views/app/pages/forms/Detail_Form"
                            ),
                    },
                ],
            },

            //Teachers
            {
                path: "/app/teachers",
                component: () =>
                    import(
                        /* webpackChunkName: "teachers" */ "./views/app/pages/teachers"
                    ),
                redirect: "app/teachers/list",
                children: [
                    {
                        name: "index_teachers",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_teachers" */ "./views/app/pages/teachers/index_teachers"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_teacher",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_teacher" */ "./views/app/pages/teachers/Add_teacher"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_teacher",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_teacher" */ "./views/app/pages/teachers/Edit_teacher"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_teacher",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_teacher" */ "./views/app/pages/teachers/Detail_Teacher"
                            ),
                    },
                ],
            },

            {
                path: "/app/Kindergrants",
                component: () =>
                    import(
                        /* webpackChunkName: "Kindergrants" */ "./views/app/pages/Kindergrants"
                    ),
                redirect: "app/Kindergrants/list",
                children: [
                    {
                        name: "index_Kindergrants",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_Kindergrants" */ "./views/app/pages/Kindergrants/index_Kindergrants"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_kindergrant",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_kindergrant" */ "./views/app/pages/Kindergrants/Add_kindergrant"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_kindergrant",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_kindergrant" */ "./views/app/pages/Kindergrants/Edit_kindergrant"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_kindergrant",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_kindergrant" */ "./views/app/pages/Kindergrants/Detail_Kindergrant"
                            ),
                    },
                ],
            },

            //Educations
            {
                path: "/app/educations",
                component: () =>
                    import(
                        /* webpackChunkName: "educations" */ "./views/app/pages/educations"
                    ),
                redirect: "app/educations/list",
                children: [
                    {
                        name: "index_educations",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_educations" */ "./views/app/pages/educations/index_educations"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_education",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_education" */ "./views/app/pages/educations/Add_education"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_education",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_education" */ "./views/app/pages/educations/Edit_education"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_education",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_education" */ "./views/app/pages/educations/Detail_Education"
                            ),
                    },
                ],
            },

            //Schools
            {
                path: "/app/schools",
                component: () =>
                    import(
                        /* webpackChunkName: "schools" */ "./views/app/pages/schools"
                    ),
                redirect: "app/schools/list",
                children: [
                    {
                        name: "index_schools",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_schools" */ "./views/app/pages/schools/index_schools"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_school",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_school" */ "./views/app/pages/schools/Add_school"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_school",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_school" */ "./views/app/pages/schools/Edit_school"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_school",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_school" */ "./views/app/pages/schools/Detail_School"
                            ),
                    },
                ],
            },

            //Universities
            {
                path: "/app/universities",
                component: () =>
                    import(
                        /* webpackChunkName: "universities" */ "./views/app/pages/universities"
                    ),
                redirect: "app/universities/list",
                children: [
                    {
                        name: "index_universities",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_universities" */ "./views/app/pages/universities/index_universities"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_universitie",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_universitie" */ "./views/app/pages/universities/Add_universitie"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_universitie",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_universitie" */ "./views/app/pages/universities/Edit_universitie"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_universitie",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_universitie" */ "./views/app/pages/universities/Detail_Universitie"
                            ),
                    },
                ],
            },

            //Specialneeds
            {
                path: "/app/specialneeds",
                component: () =>
                    import(
                        /* webpackChunkName: "specialneeds" */ "./views/app/pages/specialneeds"
                    ),
                redirect: "app/specialneeds/list",
                children: [
                    {
                        name: "index_specialneeds",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_specialneeds" */ "./views/app/pages/specialneeds/index_specialneeds"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_specialneed",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_specialneed" */ "./views/app/pages/specialneeds/Add_specialneed"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_specialneed",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_specialneed" */ "./views/app/pages/specialneeds/Edit_specialneed"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_specialneed",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_specialneed" */ "./views/app/pages/specialneeds/Detail_Specialneed"
                            ),
                    },
                ],
            },



               //Educenters
               {
                path: "/app/educenters",
                component: () =>
                    import(
                        /* webpackChunkName: "educenters" */ "./views/app/pages/educenters"
                    ),
                redirect: "app/educenters/list",
                children: [
                    {
                        name: "index_educenters",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_educenters" */ "./views/app/pages/educenters/index_educenters"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_educenter",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_educenter" */ "./views/app/pages/educenters/Add_educenter"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_educenter",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_educenter" */ "./views/app/pages/educenters/Edit_educenter"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_educenter",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_educenter" */ "./views/app/pages/educenters/Detail_Educenter"
                            ),
                    },
                ],
            },





              //Centers
     {
        path: "/app/centers",
        component: () =>
            import(
                /* webpackChunkName: "centers" */ "./views/app/pages/centers"
            ),
        redirect: "app/centers/list",
        children: [
            {
                name: "index_centers",
                path: "list",
                component: () =>
                    import(
                        /* webpackChunkName: "index_centers" */ "./views/app/pages/centers/index_centers"
                    ),
            },
            {
                path: "store",
                name: "store_center",
                component: () =>
                    import(
                        /* webpackChunkName: "store_center" */ "./views/app/pages/centers/Add_center"
                    ),
            },
            {
                path: "edit/:id",
                name: "edit_center",
                component: () =>
                    import(
                        /* webpackChunkName: "edit_center" */ "./views/app/pages/centers/Edit_center"
                    ),
            },
            {
                path: "detail/:id",
                name: "detail_center",
                component: () =>
                    import(
                        /* webpackChunkName: "detail_center" */ "./views/app/pages/centers/Detail_Center"
                    ),
            },
        ],
    },



         //Kindergartens
         {
            path: "/app/kindergartens",
            component: () =>
                import(
                    /* webpackChunkName: "kindergartens" */ "./views/app/pages/kindergartens"
                ),
            redirect: "app/kindergartens/list",
            children: [
                {
                    name: "index_kindergartens",
                    path: "list",
                    component: () =>
                        import(
                            /* webpackChunkName: "index_kindergartens" */ "./views/app/pages/kindergartens/index_kindergartens"
                        ),
                },
                {
                    path: "store",
                    name: "store_kindergarten",
                    component: () =>
                        import(
                            /* webpackChunkName: "store_kindergarten" */ "./views/app/pages/kindergartens/Add_kindergarten"
                        ),
                },
                {
                    path: "edit/:id",
                    name: "edit_kindergarten",
                    component: () =>
                        import(
                            /* webpackChunkName: "edit_kindergarten" */ "./views/app/pages/kindergartens/Edit_kindergarten"
                        ),
                },
                {
                    path: "detail/:id",
                    name: "detail_kindergarten",
                    component: () =>
                        import(
                            /* webpackChunkName: "detail_kindergarten" */ "./views/app/pages/kindergartens/Detail_Kindergarten"
                        ),
                },
            ],
        },
    



            //numbers
            {
                path: "/app/numbers",
                component: () =>
                    import(
                        /* webpackChunkName: "products" */ "./views/app/pages/numbers"
                    ),
                redirect: "app/numbers/list",
                children: [
                    {
                        name: "index_products",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_products" */ "./views/app/pages/products/index_products"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_number",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_product" */ "./views/app/pages/numbers/Add_number"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_product",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_product" */ "./views/app/pages/products/Edit_product"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_product",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_product" */ "./views/app/pages/products/Detail_Product"
                            ),
                    },
                    {
                        path: "barcode",
                        name: "barcode",
                        component: () =>
                            import(
                                /* webpackChunkName: "barcode" */ "./views/app/pages/products/barcode"
                            ),
                    },
                ],
            },

            //Products
            {
                path: "/app/products",
                component: () =>
                    import(
                        /* webpackChunkName: "products" */ "./views/app/pages/products"
                    ),
                redirect: "app/products/list",
                children: [
                    {
                        name: "index_products",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_products" */ "./views/app/pages/products/index_products"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_product",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_product" */ "./views/app/pages/products/Add_product"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_product",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_product" */ "./views/app/pages/products/Edit_product"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_product",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_product" */ "./views/app/pages/products/Detail_Product"
                            ),
                    },
                    {
                        path: "barcode",
                        name: "barcode",
                        component: () =>
                            import(
                                /* webpackChunkName: "barcode" */ "./views/app/pages/products/barcode"
                            ),
                    },
                ],
            },

            //

            //deferreds
            {
                path: "/app/deferreds",
                component: () =>
                    import(
                        /* webpackChunkName: "products" */ "./views/app/pages/deferreds"
                    ),
                redirect: "app/deferreds/list",
                children: [
                    {
                        name: "index_deferreds",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_products" */ "./views/app/pages/deferreds/index_deferreds"
                            ),
                    },
                    {
                        path: "store",
                        name: "store_deferred",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_product" */ "./views/app/pages/deferreds/Add_deferred"
                            ),
                    },
                    {
                        path: "edit/:id",
                        name: "edit_deferred",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_product" */ "./views/app/pages/deferreds/Edit_deferred"
                            ),
                    },
                    {
                        path: "detail/:id",
                        name: "detail_deferred",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_product" */ "./views/app/pages/deferreds/Detail_Deferreds"
                            ),
                    },
                ],
            },

            //Adjustement
            {
                path: "/app/adjustments",
                component: () =>
                    import(
                        /* webpackChunkName: "adjustments" */ "./views/app/pages/adjustment"
                    ),
                redirect: "/app/adjustments/list",
                children: [
                    {
                        name: "index_adjustment",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_adjustment" */
                                "./views/app/pages/adjustment/index_Adjustment"
                            ),
                    },
                    {
                        name: "store_adjustment",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_adjustment" */
                                "./views/app/pages/adjustment/Create_Adjustment"
                            ),
                    },
                    {
                        name: "edit_adjustment",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_adjustment" */
                                "./views/app/pages/adjustment/Edit_Adjustment"
                            ),
                    },
                ],
            },

            //Transfer
            {
                path: "/app/transfers",
                component: () =>
                    import(
                        /* webpackChunkName: "transfers" */ "./views/app/pages/transfers"
                    ),
                redirect: "/app/transfers/list",
                children: [
                    {
                        name: "index_transfer",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_transfer" */ "./views/app/pages/transfers/index_transfer"
                            ),
                    },
                    {
                        name: "store_transfer",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_transfer" */
                                "./views/app/pages/transfers/create_transfer"
                            ),
                    },
                    {
                        name: "edit_transfer",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_transfer" */ "./views/app/pages/transfers/edit_transfer"
                            ),
                    },
                ],
            },

            //Expense
            {
                path: "/app/expenses",
                component: () =>
                    import(
                        /* webpackChunkName: "expenses" */ "./views/app/pages/expense"
                    ),
                redirect: "/app/expenses/list",
                children: [
                    {
                        name: "index_expense",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_expense" */ "./views/app/pages/expense/index_expense"
                            ),
                    },
                    {
                        name: "store_expense",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_expense" */ "./views/app/pages/expense/Create_expense"
                            ),
                    },
                    {
                        name: "edit_expense",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_expense" */ "./views/app/pages/expense/Edit_expense"
                            ),
                    },
                    {
                        name: "expense_category",
                        path: "category",
                        component: () =>
                            import(
                                /* webpackChunkName: "expense_category" */ "./views/app/pages/expense/category_expense"
                            ),
                    },
                ],
            },

            //Quotation
            {
                path: "/app/quotations",
                component: () =>
                    import(
                        /* webpackChunkName: "quotations" */ "./views/app/pages/quotations"
                    ),
                redirect: "/app/quotations/list",
                children: [
                    {
                        name: "index_quotation",
                        path: "list",
                        component: () =>
                            import(
                                "./views/app/pages/quotations/index_quotation"
                            ),
                    },
                    {
                        name: "store_quotation",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_quotation" */
                                "./views/app/pages/quotations/create_quotation"
                            ),
                    },
                    {
                        name: "edit_quotation",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_quotation" */
                                "./views/app/pages/quotations/edit_quotation"
                            ),
                    },
                    {
                        name: "detail_quotation",
                        path: "detail/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_quotation" */
                                "./views/app/pages/quotations/detail_quotation"
                            ),
                    },
                    {
                        name: "change_to_sale",
                        path: "create_sale/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "change_to_sale" */ "./views/app/pages/sales/change_to_sale.vue"
                            ),
                    },
                ],
            },

            //Purchase
            {
                path: "/app/purchases",
                component: () =>
                    import(
                        /* webpackChunkName: "purchases" */ "./views/app/pages/purchases"
                    ),
                redirect: "/app/purchases/list",
                children: [
                    {
                        name: "index_purchases",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_purchases" */ "./views/app/pages/purchases/index_purchase"
                            ),
                    },
                    {
                        name: "store_purchase",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_purchase" */
                                "./views/app/pages/purchases/create_purchase"
                            ),
                    },
                    {
                        name: "edit_purchase",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_purchase" */ "./views/app/pages/purchases/edit_purchase"
                            ),
                    },
                    {
                        name: "detail_purchase",
                        path: "detail/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_purchase" */
                                "./views/app/pages/purchases/detail_purchase"
                            ),
                    },
                ],
            },

            //Sale
            {
                path: "/app/sales",
                component: () =>
                    import(
                        /* webpackChunkName: "sales" */ "./views/app/pages/sales"
                    ),
                redirect: "/app/sales/list",
                children: [
                    {
                        name: "index_sales",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_sales" */ "./views/app/pages/sales/index_sale"
                            ),
                    },
                    {
                        name: "store_sale",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_sale" */ "./views/app/pages/sales/create_sale"
                            ),
                    },
                    {
                        name: "edit_sale",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_sale" */ "./views/app/pages/sales/edit_sale"
                            ),
                    },
                    {
                        name: "detail_sale",
                        path: "detail/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_sale" */ "./views/app/pages/sales/detail_sale"
                            ),
                    },
                ],
            },

            // Sales Return
            {
                path: "/app/sale_return",
                component: () =>
                    import(
                        /* webpackChunkName: "sale_return" */ "./views/app/pages/sale_return"
                    ),
                redirect: "/app/sale_return/list",
                children: [
                    {
                        name: "index_sale_return",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_sale_return" */
                                "./views/app/pages/sale_return/index_sale_return"
                            ),
                    },
                    {
                        name: "store_sale_return",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_sale_return" */
                                "./views/app/pages/sale_return/create_sale_return"
                            ),
                    },
                    {
                        name: "edit_sale_return",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_sale_return" */
                                "./views/app/pages/sale_return/edit_sale_return"
                            ),
                    },
                    {
                        name: "detail_sale_return",
                        path: "detail/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_sale_return" */
                                "./views/app/pages/sale_return/detail_sale_return"
                            ),
                    },
                ],
            },

            // purchase Return
            {
                path: "/app/purchase_return",
                component: () =>
                    import(
                        /* webpackChunkName: "purchase_return" */ "./views/app/pages/purchase_return"
                    ),
                redirect: "/app/purchase_return/list",
                children: [
                    {
                        name: "index_purchase_return",
                        path: "list",
                        component: () =>
                            import(
                                /* webpackChunkName: "index_purchase_return" */
                                "./views/app/pages/purchase_return/index_purchase_return"
                            ),
                    },
                    {
                        name: "store_purchase_return",
                        path: "store",
                        component: () =>
                            import(
                                /* webpackChunkName: "store_purchase_return" */
                                "./views/app/pages/purchase_return/create_purchase_return"
                            ),
                    },
                    {
                        name: "edit_purchase_return",
                        path: "edit/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "edit_purchase_return" */
                                "./views/app/pages/purchase_return/edit_purchase_return"
                            ),
                    },
                    {
                        name: "detail_purchase_return",
                        path: "detail/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_purchase_return" */
                                "./views/app/pages/purchase_return/detail_purchase_return"
                            ),
                    },
                ],
            },

                           //Blogs
                           {
                            path: "/app/blogs",
                            component: () => import(/* webpackChunkName: "blogs" */ "./views/app/pages/blogs"),
                            redirect: "app/blogs/list",
                            children: [
                                {
                                    name: "index_blogs",
                                    path: "list",
                                    component: () =>
                                        import(/* webpackChunkName: "index_blogs" */"./views/app/pages/blogs/index_blogs")
                                },
                                {
                                    path: "store",
                                    name: "store_blog",
                                    component: () =>
                                        import(/* webpackChunkName: "store_blog" */"./views/app/pages/blogs/Add_blog")
                                },
                                {
                                    path: "edit/:id",
                                    name: "edit_blog",
                                    component: () =>
                                        import(/* webpackChunkName: "edit_blog" */"./views/app/pages/blogs/Edit_blog")
                                },
                                {
                                    path: "detail/:id",
                                    name: "detail_blog",
                                    component: () =>
                                        import(/* webpackChunkName: "detail_blog" */"./views/app/pages/blogs/Detail_Blog")
                                }
                           
                            ]
                        },

                        


            // People
            {
                path: "/app/People",
                component: () =>
                    import(
                        /* webpackChunkName: "People" */ "./views/app/pages/people"
                    ),
                redirect: "/app/People/Customers",
                children: [
                    // Customers
                    {
                        name: "Customers",
                        path: "Customers",
                        component: () =>
                            import(
                                /* webpackChunkName: "Customers" */ "./views/app/pages/people/customers"
                            ),
                    },

                    // Suppliers
                    {
                        name: "Suppliers",
                        path: "Suppliers",
                        component: () =>
                            import(
                                /* webpackChunkName: "Suppliers" */ "./views/app/pages/people/providers"
                            ),
                    },

                    // Users
                    {
                        name: "user",
                        path: "Users",
                        component: () =>
                            import(
                                /* webpackChunkName: "Users" */ "./views/app/pages/people/users"
                            ),
                    },
                ],
            },

            // Settings
            {
                path: "/app/settings",
                component: () =>
                    import(
                        /* webpackChunkName: "settings" */ "./views/app/pages/settings"
                    ),
                redirect: "/app/settings/System_settings",
                children: [
                    // Permissions
                    {
                        path: "permissions",
                        component: () =>
                            import(
                                /* webpackChunkName: "permissions" */ "./views/app/pages/settings/permissions"
                            ),
                        redirect: "/app/settings/permissions/list",
                        children: [
                            {
                                name: "groupPermission",
                                path: "list",
                                component: () =>
                                    import(
                                        /* webpackChunkName: "groupPermission" */
                                        "./views/app/pages/settings/permissions/Permissions"
                                    ),
                            },

                            // drops

                            {
                                name: "store_permission",
                                path: "store",
                                component: () =>
                                    import(
                                        /* webpackChunkName: "store_permission" */
                                        "./views/app/pages/settings/permissions/Create_permission"
                                    ),
                            },                             // reviews
                 

                            {
                                name: "edit_permission",
                                path: "edit/:id",
                                component: () =>
                                    import(
                                        /* webpackChunkName: "edit_permission" */
                                        "./views/app/pages/settings/permissions/Edit_permission"
                                    ),
                            },
                        ],
                    },




                    // govs
                    {
                    name: "govs",
                    path: "Govs",
                    component: () =>
                        import(/* webpackChunkName: "Govs" */"./views/app/pages/settings/govs")
                    },


                    {
                        name: "reviews",
                        path: "Reviews",
                        component: () =>
                            import(/* webpackChunkName: "Reviews" */"./views/app/pages/settings/reviews")
                    },

                    // categories
                    {
                        name: "categories",
                        path: "Categories",
                        component: () =>
                            import(
                                /* webpackChunkName: "Categories" */ "./views/app/pages/settings/categorie"
                            ),
                    },


                                // deals
                                {
                                    name: "deals",
                                    path: "Deals",
                                    component: () =>
                                        import(/* webpackChunkName: "Deals" */"./views/app/pages/settings/deals")
                                },


                                
                          // recentlys
                    {
                        name: "recentlys",
                        path: "Recentlys",
                        component: () =>
                            import(/* webpackChunkName: "Recentlys" */"./views/app/pages/settings/recentlys")
                    },

                    // sections
                    {
                        name: "sections",
                        path: "Section",
                        component: () =>
                            import(
                                /* webpackChunkName: "Section" */ "./views/app/pages/settings/sections"
                            ),
                    },

                    {
                        name: "drops",
                        path: "Drops",
                        component: () =>
                            import(
                                /* webpackChunkName: "Drops" */ "./views/app/pages/settings/drops"
                            ),
                    },

                    // areas
                    {
                        name: "areas",
                        path: "Areas",
                        component: () =>
                            import(
                                /* webpackChunkName: "Areas" */ "./views/app/pages/settings/areas"
                            ),
                    },

                    // brands
                    {
                        name: "brands",
                        path: "Brands",
                        component: () =>
                            import(
                                /* webpackChunkName: "Brands" */ "./views/app/pages/settings/brands"
                            ),
                    },

                    // institutions
                    {
                        name: "institutions",
                        path: "Institutions",
                        component: () =>
                            import(
                                /* webpackChunkName: "Institutions" */ "./views/app/pages/settings/institutions"
                            ),
                    },

                    // currencies
                    {
                        name: "currencies",
                        path: "Currencies",
                        component: () =>
                            import(
                                /* webpackChunkName: "Currencies" */ "./views/app/pages/settings/currencies"
                            ),
                    },

                    // units
                    {
                        name: "units",
                        path: "Units",
                        component: () =>
                            import(
                                /* webpackChunkName: "units" */ "./views/app/pages/settings/units"
                            ),
                    },

                    // cats
                    {
                        name: "cats",
                        path: "Cats",
                        component: () =>
                            import(
                                /* webpackChunkName: "Cats" */ "./views/app/pages/settings/cats"
                            ),
                    },
                    // Backup
                    {
                        name: "Backup",
                        path: "Backup",
                        component: () =>
                            import(
                                /* webpackChunkName: "Backup" */ "./views/app/pages/settings/backup"
                            ),
                    },

                    // Warehouses
                    {
                        name: "Warehouses",
                        path: "Warehouses",
                        component: () =>
                            import(
                                /* webpackChunkName: "Warehouses" */ "./views/app/pages/settings/warehouses"
                            ),
                    },

                    // System Settings
                    {
                        name: "system_settings",
                        path: "System_settings",
                        component: () =>
                            import(
                                /* webpackChunkName: "System_settings" */ "./views/app/pages/settings/system_settings"
                            ),
                    },
                    // updates
                    //  {
                    //     name: "updates",
                    //     path: "updates",
                    //     component: () =>
                    //         import(/* webpackChunkName: "updates" */"./views/app/pages/settings/updates")
                    // }
                ],
            },

            // Reports
            {
                path: "/app/reports",
                component: () => import("./views/app/pages/reports"),
                redirect: "/app/reports/profit_and_loss",
                children: [
                    {
                        name: "payments_purchases",
                        path: "payments_purchase",
                        component: () =>
                            import(
                                /* webpackChunkName: "payments_purchases" */
                                "./views/app/pages/reports/payments/payments_purchases"
                            ),
                    },
                    {
                        name: "payments_sales",
                        path: "payments_sale",
                        component: () =>
                            import(
                                /* webpackChunkName: "payments_sales" */
                                "./views/app/pages/reports/payments/payments_sales"
                            ),
                    },


                    {
                        name: "payments_purchases_returns",
                        path: "payments_purchases_returns",
                        component: () =>
                            import(
                                /* webpackChunkName: "payments_purchases_returns" */
                                "./views/app/pages/reports/payments/payments_purchases_returns"
                            ),
                    },
                    {
                        name: "payments_sales_returns",
                        path: "payments_sales_returns",
                        component: () =>
                            import(
                                /* webpackChunkName: "payments_sales_returns" */
                                "./views/app/pages/reports/payments/payments_sales_returns"
                            ),
                    },

                    {
                        name: "profit_and_loss",
                        path: "profit_and_loss",
                        component: () =>
                            import(
                                /* webpackChunkName: "profit_and_loss" */
                                "./views/app/pages/reports/profit_and_loss"
                            ),
                    },

                    {
                        name: "quantity_alerts",
                        path: "quantity_alerts",
                        component: () =>
                            import(
                                /* webpackChunkName: "quantity_alerts" */
                                "./views/app/pages/reports/quantity_alerts"
                            ),
                    },
                    {
                        name: "warehouse_report",
                        path: "warehouse_report",
                        component: () =>
                            import(
                                /* webpackChunkName: "warehouse_report" */
                                "./views/app/pages/reports/warehouse_report"
                            ),
                    },

                    {
                        name: "sales_report",
                        path: "sales_report",
                        component: () =>
                            import(
                                /* webpackChunkName: "sales_report" */
                                "./views/app/pages/reports/sales_report"
                            ),
                    },
                    {
                        name: "purchase_report",
                        path: "purchase_report",
                        component: () =>
                            import(
                                /* webpackChunkName: "purchase_report" */
                                "./views/app/pages/reports/purchase_report"
                            ),
                    },

                    {
                        name: "customers_report",
                        path: "customers_report",
                        component: () =>
                            import(
                                /* webpackChunkName: "customers_report" */
                                "./views/app/pages/reports/customers_report"
                            ),
                    },
                    {
                        name: "detail_customer_report",
                        path: "detail_customer/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_customer_report" */
                                "./views/app/pages/reports/detail_Customer_Report"
                            ),
                    },

                    {
                        name: "providers_report",
                        path: "providers_report",
                        component: () =>
                            import(
                                /* webpackChunkName: "providers_report" */
                                "./views/app/pages/reports/providers_report"
                            ),
                    },
                    {
                        name: "detail_supplier_report",
                        path: "detail_supplier/:id",
                        component: () =>
                            import(
                                /* webpackChunkName: "detail_supplier_report" */
                                "./views/app/pages/reports/detail_Supplier_Report"
                            ),
                    },
                ],
            },

            {
                name: "profile",
                path: "/app/profile",
                component: () =>
                    import(
                        /* webpackChunkName: "profile" */ "./views/app/pages/profile"
                    ),
            },
        ],
    },

    {
        name: "pos",
        path: "/app/pos",
        // beforeEnter: authenticate,
        component: () =>
            import(/* webpackChunkName: "pos" */ "./views/app/pages/pos"),
    },

    {
        path: "*",
        name: "NotFound",
        component: () =>
            import(
                /* webpackChunkName: "NotFound" */ "./views/app/pages/notFound"
            ),
    },

    {
        path: "not_authorize",
        name: "not_authorize",
        component: () =>
            import(
                /* webpackChunkName: "not_authorize" */ "./views/app/pages/NotAuthorize"
            ),
    },
];

const router = new Router({
    mode: "history",
    linkActiveClass: "open",
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { x: 0, y: 0 };
    },
});

const originalPush = Router.prototype.push;
Router.prototype.push = function push(location, onResolve, onReject) {
    if (onResolve || onReject)
        return originalPush.call(this, location, onResolve, onReject);
    return originalPush.call(this, location).catch((err) => err);
};

router.beforeEach((to, from, next) => {
    // If this isn't an initial page load.
    if (to.path) {
        // Start the route progress bar.
        NProgress.start();
        NProgress.set(0.1);
    }
    next();

    if (
        store.state.language.language &&
        store.state.language.language !== i18n.locale
    ) {
        i18n.locale = store.state.language.language;
        next();
    } else if (!store.state.language.language) {
        store.dispatch("language/setLanguage", navigator.languages).then(() => {
            i18n.locale = store.state.language.language;
            next();
        });
    } else {
        next();
    }
});

router.afterEach(() => {
    // Remove initial loading
    const gullPreLoading = document.getElementById("loading_wrap");
    if (gullPreLoading) {
        gullPreLoading.style.display = "none";
    }
    // Complete the animation of the route progress bar.
    setTimeout(() => NProgress.done(), 500);
    // NProgress.done();

    if (window.innerWidth <= 1200) {
        store.dispatch("changeSidebarProperties");
        if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
            store.dispatch("changeSecondarySidebarProperties");
        }

        if (store.getters.getCompactSideBarToggleProperties.isSideNavOpen) {
            store.dispatch("changeCompactSidebarProperties");
        }
    } else {
        if (store.getters.getSideBarToggleProperties.isSecondarySideNavOpen) {
            store.dispatch("changeSecondarySidebarProperties");
        }
    }
});

async function Check_Token(to, from, next) {
    let token = to.params.token;
    const res = await axios
        .get("password/find/" + token)
        .then((response) => response.data);

    if (!res.success) {
        next("/app/sessions/signIn");
    } else {
        return next();
    }
}

export default router;
