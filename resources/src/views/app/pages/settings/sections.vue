
<template>
  <div class="main-content">
    <breadcumb :page="$t('Section')" :folder="$t('Settings')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <b-card class="wrapper" v-if="!isLoading">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="sections"
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
          <b-button @click="New_Section()" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <i class="i-Add"></i>
             {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <a @click="Edit_Section(props.row)" title="Edit" v-b-tooltip.hover>
              <i class="i-Edit text-25 text-success"></i>
            </a>
            <a title="Delete" v-b-tooltip.hover @click="Delete_Section(props.row.id)">
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
 
        </template>
      </vue-good-table>
    </b-card>

    <validation-observer ref="Create_section">
      <b-modal hide-footer size="md" id="New_section" :title="editmode?$t('Edit'):$t('Add')">
        <b-form @submit.prevent="Submit_Section" enctype="multipart/form-data">
          <b-row>
            <!-- Section Name -->


            <b-col md="12" class="mb-12">
                  <validation-provider name="Type" :rules="{ required: true}">
                    <b-form-group slot-scope="{ valid, errors }" :label="$t('Type')">
                      <v-select
                        :class="{'is-invalid': !!errors.length}"
                        :state="errors[0] ? false : (valid ? true : null)"
                        v-model="section.section_type"
                        :reduce="label => label.value"
                        :placeholder="$t('Type')"
                       
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


                


            <b-col md="12">
                  <validation-provider
                    name="ar_Name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('Name_ar_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="ar_name"
                        :placeholder="$t('Enter_Name_ar_name')"
                        v-model="section.ar_name"
                      ></b-form-input>
                      <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                    </b-form-group>
                  </validation-provider>
            </b-col>

            <!-- Section -->
            <b-col md="12">
              <validation-provider
                    name="en_Name"
                    :rules="{required:true , min:3 , max:55}"
                    v-slot="validationContext">
                    <b-form-group :label="$t('Name_en_name')">
                      <b-form-input
                        :state="getValidationState(validationContext)"
                        aria-describedby="Name-feedback"
                        label="en_name"
                        :placeholder="$t('Enter_Name_en_name')"
                        v-model="section.en_name"
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
    title: "Section"
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
      sections: [],
      limit: "10",
      section: {
        id: "",
        ar_name: "",
        en_name: "",
        section_type: ""
      }
    };
  },
  computed: {
    columns() {
      return [
        {
          label: this.$t("type"),
          field: "type",
          tdClass: "text-left",
          thClass: "text-left"
        },
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
    //---- update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Sections(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Sections(1);
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
      this.Get_Sections(this.serverParams.page);
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
      this.Get_Sections(this.serverParams.page);
    },

    //---- Validation State Form

    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    //------------- Submit Validation Create & Edit Section
    Submit_Section() {
      this.$refs.Create_section.validate().then(success => {
        if (!success) {
          this.makeToast(
            "danger",
            this.$t("Please_fill_the_form_correctly"),
            this.$t("Failed")
          );
        } else {
          if (!this.editmode) {
            this.Create_Section();
          } else {
            this.Update_Section();
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
        this.section.image = e.target.files[0];
      } else {
        this.section.image = "";
      }
    },

    //------------------------------ Modal (create Section) -------------------------------\
    New_Section() {
      this.reset_Form();
      this.editmode = false;
      this.$bvModal.show("New_section");
    },

    //------------------------------ Modal (Update Section) -------------------------------\
    Edit_Section(section) {
      this.Get_Sections(this.serverParams.page);
      this.reset_Form();
      this.section = section;
      this.editmode = true;
      this.$bvModal.show("New_section");
    },

    //---------------------------------------- Get All sections-----------------\
    Get_Sections(page) {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get(
          "sections?page=" +
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
          this.sections = response.data.sections;
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

    //---------------------------------------- Create new section-----------------\
    Create_Section() {
      var self = this;
      self.SubmitProcessing = true;
      self.data.append("ar_name", self.section.ar_name);
      self.data.append("en_name", self.section.en_name);
      self.data.append("type", self.section.section_type);
      axios
        .post("sections", self.data)
        .then(response => {
          self.SubmitProcessing = false;
          Fire.$emit("Event_Section");

          this.makeToast(
            "success",
            this.$t("Create.TitleSection"),
            this.$t("Success")
          );
        })
        .catch(error => {
           self.SubmitProcessing = false;
          this.makeToast("danger", this.$t("InvalidData"), this.$t("Failed"));
        });
    },

    //---------------------------------------- Update Section-----------------\
    Update_Section() {
      var self = this;
       self.SubmitProcessing = true;
      self.data.append("en_name", self.section.en_name);
      self.data.append("ar_name", self.section.ar_name);
      self.data.append("type", self.section.section_type);
      self.data.append("_method", "put");

      axios
        .post("sections/" + self.section.id, self.data)
        .then(response => {
           self.SubmitProcessing = false;
          Fire.$emit("Event_Section");

          this.makeToast(
            "success",
            this.$t("Update.TitleSection"),
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
      this.section = {
        id: "",
        ar_name: "",
        en_name: "",
        section_type: ""
      };
      this.data = new FormData();
    },

    //---------------------------------------- Delete Section -----------------\
    Delete_Section(id) {
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
            .delete("sections/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleSection"),
                "success"
              );

              Fire.$emit("Delete_Section");
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

    //---- Delete sections by selection

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
            .post("sections/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.TitleSection"),
                "success"
              );

              Fire.$emit("Delete_Section");
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
    this.Get_Sections(1);

    Fire.$on("Event_Section", () => {
      setTimeout(() => {
        this.Get_Sections(this.serverParams.page);
        this.$bvModal.hide("New_section");
      }, 500);
    });

    Fire.$on("Delete_Section", () => {
      setTimeout(() => {
        this.Get_Sections(this.serverParams.page);
      }, 500);
    });
  }
};
</script>