
<template>
  <div class="main-content">
    <breadcumb :page="$t('Recently')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="recentlys"
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
          <b-button @click="New_Recently()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <a @click="Edit_Recently(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Recently(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/recentlys/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_recently">
      <b-modal hide-footer size="md" id="New_recently" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Recently" enctype="multipart/form-data">
          <b-row>
            <!-- Recently Name -->



            <b-col md="12" class="mb-12">
                  <validation-provider name="type" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Type')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="recently.type"
                        :reduce="label => label.value"
                        :placeholder="$t('Type')"
                        v-on:input="handleChange"
                        :options="
                            [

                              {label: 'SCHOOLS', value: 'SCHOOLS'},
                              {label: 'KINDERGARTENS', value: 'KINDERGARTENS'},
                              {label: 'EDUCENTERS', value: 'EDUCENTERS'},
                              {label: 'UNIVERSITIES', value: 'UNIVERSITIES'},
                              {label: 'SPECIALNEEDS', value: 'SPECIALNEEDS'},
                              {label: 'CENTERS', value: 'CENTERS'},
                              {label: 'TEACHERS', value: 'TEACHERS'},

            
                            ]"
                      ></v-select>
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
                </b-col>

           

      
                <b-col md="12" class="mb-12">
                  <validation-provider name="Type" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('chooseInst')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        :reduce="label => label.value"
                        :placeholder="$t('chooseInst')"
                        v-model="recently.child_id"
                        :options="types.map(types => ({label: types.ar_name, value: types.id}))"
                      />
                      <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
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
    title: "Recently"
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
      recentlys: [],
      limit: "10",
      types:[],
      recently: {
        id: "",
        child_id: "",
        type: ""
      }
    };
  },
  computed: {
    columns() {
      return [
  
        {
          label: this.$t("en_name"),
          field: "en_name",
          tdClass: "text-left",
          thClass: "text-left"
        },
        {
          label: this.$t("ar_name"),
          field: "ar_name",
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


    handleChange(selectedValue){
      
      this.getItems(selectedValue);

    },



    getItems(type){

  
// Start the progress bar.
// NProgress.start();
// NProgress.set(0.1);
axios.get(
    "types/gettypesinst?type=" +  type 
      
  )
  .then(response => {
    this.types = response.data.types;
 
 
  })
  .catch(response => {
    // Complete the animation of theprogress bar.
    NProgress.done();
    setTimeout(() => {
      this.isLoading = false;
    }, 500);
  });

},




    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Recentlys(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Recentlys(1);
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
      this.Get_Recentlys(this.serverParams.page);
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
      this.Get_Recentlys(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Recently
    Submit_Recently() {
      this.$refs.Create_recently.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Recently();
          } else {
            this.Update_Recently();
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
        this.recently.image = e.target.files[0];
      } else {
        this.recently.image = "";
      }
    },

    //------------------------------ Modal (create Recently) -------------------------------\
    New_Recently() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_recently");
    },

    //------------------------------ Modal (Update Recently) -------------------------------\
    Edit_Recently(recently) {
      this.Get_Recentlys(this.serverParams.page);
      this.reset_Form();
      this.recently = recently;
      this.editmode = true;
      this.$bvModal.show("New_recently");
    },

    //---------------------------------------- Get All recentlys-----------------\
    Get_Recentlys(page) {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "recentlys?page=" +
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
          this.recentlys = response.data.recentlys;
          this.totalRows = response.data.totalRows;

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

    //---------------------------------------- Create new recently-----------------\
    Create_Recently() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("child_id", self.recently.child_id);
      self.data.append("type", self.recently.type);
      axios
        .post("recentlys", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Recently");

          this.makeToast(
            "success",
            this.$t("Create.TitleRecently"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Recently-----------------\
    Update_Recently() {
      var self = this;
       self.SubmitProcessing = true;
       self.data.append("child_id", self.recently.child_id);
      self.data.append("type", self.recently.type);
      self.data.append("_method", "put");

      axios
        .post("recentlys/" + self.recently.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Recently");

          this.makeToast(
            "success",
            this.$t("Update.TitleRecently"),
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
      this.recently = {
        id: "",
        child_id: "",
        type: "",
 
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Recently -----------------\
    Delete_Recently(id) {
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
            .delete("recentlys/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleRecently"),
                "success"
              );

              Fire.$emit("Delete_Recently");
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

    //---- Delete recentlys by selection

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
            .post("recentlys/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleRecently"),
                "success"
              );

              Fire.$emit("Delete_Recently");
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
    this.Get_Recentlys(1);

    Fire.$on("Event_Recently", () => {
      setTimeout(() => {
        this.Get_Recentlys(this.serverParams.page);
        this.$bvModal.hide("New_recently");
      }, 500);
    });

    Fire.$on("Delete_Recently", () => {
      setTimeout(() => {
        this.Get_Recentlys(this.serverParams.page);
      }, 500);
    });
  }
};
</script>