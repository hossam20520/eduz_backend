<template>
  <div class="main-content">
    <breadcumb :page="$t('Review')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="reviews"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        @on-search="onSearch"
        :search-options="{
        enabled: true,
        placeholder: $t('Search_this_table'),  
      }"
        :select-options="{ 
          enabled: true ,
          clearSelectionText: '',
        }"
        @on-selected-rows-change="selectionChanged"
        :pagination-options="{
        enabled: true,
        mode: 'records',
        nextLabel: 'next',
        prevLabel: 'prev',
      }"
        styleClass="table-hover tableOne vgt-table"
      >
        <div slot="selected-row-actions">
          <button class="btn btn-danger btn-sm" @click="delete_by_selected()"> {{ $t('Del') }}</button>
        </div>
        <div slot="table-actions" class="mt-2 mb-3">
          <b-button @click="New_Review()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <a @click="Edit_Review(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Review(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
      
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_review">
      <b-modal hide-footer size="md" id="New_review" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Review" enctype="multipart/form-data">
          <b-row>
            <!-- Review Name -->
 

            
               <!-- Category -->
                 <b-col md="12" class="mb-2">
                  <validation-provider name="user" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('user')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_user')"
                        v-model="review.user_id"
                        :options="users.map(users => ({label: users.email, value: users.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

                

                <b-col md="12" class="mb-2">
                  <validation-provider name="Type" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Type')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="review.type"
                        :reduce="label => label.value"
                        :placeholder="$t('Type')"
                        v-on:input="handleChange"
                        :options="
                            [

                              {label: 'SCHOOLS', value: 'SCHOOLS'},
                              {label: 'KINDERGARTENS', value: 'KINDERGARTENS'},
                              {label: 'SPECIALNEEDS', value: 'SPECIALNEEDS'},
                              {label: 'CENTERS', value: 'CENTERS'},
                     

            
                            ]"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                            
             
                <b-col md="12" class="mb-2">
                  <validation-provider name="user" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('insts')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_inst')"
                        v-model="review.inst_id"
                        :options="insts.map(insts => ({label: insts.ar_name, value: insts.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>



                <b-col md="12" class="mb-2">
                  <validation-provider name="  approve" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('approve')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="review.approve"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_status')"
                        :options="
                           [
                            {label: 'approved', value: 'approved'},
                            {label: 'pending', value: 'pending'}
                           ]"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

     
 
                <b-col md="12" class="mb-2">
                  <validation-provider
                    name="Product Cost"
                    :rules="{ required: true , regex: /^\d*\.?\d*$/}"
                    v-slot="validationContext"
                  >
                    <b-form-group :label="$t('review_num')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="ProductCost-feedback"
                        label="review_num"
                        :placeholder="$t('count')"
                        v-model="review.count"
                      ></b-form-input>
                      <b-form-invalid-feedback
                        id="ProductCost-feedback"
                      >{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

                <b-col md="12" class="mb-2">
                  <validation-provider
                    name="ar_Name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('review')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('Enter_review')"
                        v-model="review.review"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>



            <b-col md="12" class="mt-3">
              <b-button variant="primary" type="submit"  :disabled="SubmitProcessing"> {{  $t('submit') }}</b-button>
                <div v-once class="typo__p" v-if="SubmitProcessing">
                  <div class="spinner sm spinner-primary mt-3"></div>
                </div>
            </b-col>

          </b-row>
        </b-form>
      </b-modal>
    </validation-observer>
  </div>
</template>

<script>
import NProgress from "nprogress";

export default {
  metaInfo: {
    title: "Review"
  },
  data() {
    return {
      isLoading: true,
      SubmitProcessing:false,
      serverParams: {
        columnFilters: {},
        sort: {
          field: "id",
          type: "desc"
        },
        page: 1,
        perPage: 10
      },
      selectedIds: [],
      totalRows: "",
      search: "",
      data: new FormData(),
      editmode: false,
      reviews: [],
      users:[],
      limit: "10",
      insts:[],
      review: {
        id: "",
        approve:"",
        count:"",
        review:"",
        user_id:"",
        inst_id:"",
        type:"",
        
      }
    };
  },
  computed: {
    columns() {
      return [
        {
          label: this.$t("first_name"),
          field: "first_name",
          tdClass: "text-left",
          thClass: "text-left"
        },


        {
          label: this.$t("last_name"),
          field: "last_name",
          tdClass: "text-left",
          thClass: "text-left"
        },
 
        {
          label: this.$t("email"),
          field: "email",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("phone"),
          field: "phone",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("review"),
          field: "review",
          tdClass: "text-left",
          thClass: "text-left"
        },


        {
          label: this.$t("count"),
          field: "count",
          tdClass: "text-left",
          thClass: "text-left"
        },

        
        {
          label: this.$t("type"),
          field: "type",
          tdClass: "text-left",
          thClass: "text-left"
        },

        {
          label: this.$t("approve"),
          field: "approve",
          tdClass: "text-left",
          thClass: "text-left"
        },


        {
          label: this.$t("Action"),
          field: "actions",
          html: true,
          tdClass: "text-right",
          thClass: "text-right",
          sortable: false
        }
      ];
    }
  },

  methods: {

    GetInsts(type) {
      axios
        .get("reviews/insts/?type="+type)
        .then(response => {
          this.insts = response.data.insts;
  
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },


    handleChange(selectedValue){
 
      this.GetInsts(selectedValue);

    },

    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Reviews(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Reviews(1);
      }
    },

    //---- Event on Sort Change
    onSortChange(params) {
      this.updateParams({
        sort: {
          type: params[0].type,
          field: params[0].field
        }
      });
      this.Get_Reviews(this.serverParams.page);
    },

    //---- Event Select Rows
    selectionChanged({ selectedRows }) {
      this.selectedIds = [];
      selectedRows.forEach((row, index) => {
        this.selectedIds.push(row.id);
      });
    },

    //---- Event on Search

    onSearch(value) {
      this.search = value.searchTerm;
      this.Get_Reviews(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Review
    Submit_Review() {
      this.$refs.Create_review.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Review();
          } else {
            this.Update_Review();
          }
        }
      });
    },

    //------ Toast
    makeToast(variant, msg, title) {
      this.$root.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true
      });
    },

    //------------------------------ Event Upload Image -------------------------------\
    async onFileSelected(e) {
      const { valid } = await this.$refs.Image.validate(e);

      if (valid) {
        this.review.image = e.target.files[0];
      } else {
        this.review.image = "";
      }
    },

    //------------------------------ Modal (create Review) -------------------------------\
    New_Review() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_review");
    },

    //------------------------------ Modal (Update Review) -------------------------------\
    Edit_Review(review) {
      this.Get_Reviews(this.serverParams.page);
      this.reset_Form();
      this.review = review;
      this.editmode = true;
      this.$bvModal.show("New_review");
    },

    //---------------------------------------- Get All reviews-----------------\
    Get_Reviews(page) {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "reviews?page=" +
            page +
            "&SortField=" +
            this.serverParams.sort.field +
            "&SortType=" +
            this.serverParams.sort.type +
            "&search=" +
            this.search +
            "&limit=" +
            this.limit
        )
        .then(response => {
          this.reviews = response.data.reviews;
          this.totalRows = response.data.totalRows;
          this.users = response.data.users;

          // Complete the animation of theprogress bar.
          NProgress.done();
          this.isLoading = false;
        })
        .catch(response => {
          // Complete the animation of theprogress bar.
          NProgress.done();
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    },

    //---------------------------------------- Create new review-----------------\
    Create_Review() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("approve", self.review.approve);
      self.data.append("count", self.review.count);
      self.data.append("review", self.review.review);
      self.data.append("user_id", self.review.user_id);
      self.data.append("inst_id", self.review.inst_id);
      self.data.append("type", self.review.type);
      axios
        .post("reviews", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Review");

          this.makeToast(
            "success",
            this.$t("Create.TitleReview"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Review-----------------\
    Update_Review() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("approve", self.review.approve);
      self.data.append("count", self.review.count);
      self.data.append("review", self.review.review);
      self.data.append("user_id", self.review.user_id);
      self.data.append("inst_id", self.review.inst_id);
      self.data.append("type", self.review.type);
      self.data.append("_method", "put");

      axios
        .post("reviews/" + self.review.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Review");

          this.makeToast(
            "success",
            this.$t("Update.TitleReview"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Reset Form -----------------\
    reset_Form() {
      this.review = {
        id: "",
        approve: "",
        count: "",
        review: "",
        user_id: "",
        inst_id: "",
        type: "",
   
 

      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Review -----------------\
    Delete_Review(id) {
      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(result => {
        if (result.value) {
          axios
            .delete("reviews/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleReview"),
                "success"
              );

              Fire.$emit("Delete_Review");
            })
            .catch(() => {
              this.$swal(
                this.$t("Delete.Failed"),
                this.$t("Delete.Therewassomethingwronge"),
                "warning"
              );
            });
        }
      });
    },

    //---- Delete reviews by selection

    delete_by_selected() {
      this.$swal({
        title: this.$t("Delete.Title"),
        text: this.$t("Delete.Text"),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: this.$t("Delete.cancelButtonText"),
        confirmButtonText: this.$t("Delete.confirmButtonText")
      }).then(result => {
        if (result.value) {
          // Start the progress bar.
          NProgress.start();
          NProgress.set(0.1);
          axios
            .post("reviews/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleReview"),
                "success"
              );

              Fire.$emit("Delete_Review");
            })
            .catch(() => {
              // Complete the animation of theprogress bar.
              setTimeout(() => NProgress.done(), 500);
              this.$swal(
                this.$t("Delete.Failed"),
                this.$t("Delete.Therewassomethingwronge"),
                "warning"
              );
            });
        }
      });
    }
  }, //end Methods
  created: function() {
    this.Get_Reviews(1);

    Fire.$on("Event_Review", () => {
      setTimeout(() => {
        this.Get_Reviews(this.serverParams.page);
        this.$bvModal.hide("New_review");
      }, 500);
    });

    Fire.$on("Delete_Review", () => {
      setTimeout(() => {
        this.Get_Reviews(this.serverParams.page);
      }, 500);
    });
  }
};
</script>