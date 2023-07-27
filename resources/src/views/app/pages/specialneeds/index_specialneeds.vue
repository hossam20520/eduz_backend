<template>
  <div class="main-content">
    <breadcumb :page="$t('specialneedsList')" :folder="$t('Specialneeds')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <div v-else>
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="specialneeds"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        @on-search="onSearch"
        :select-options="{ 
          enabled: true ,
          clearSelectionText: '',
        }"
        @on-selected-rows-change="selectionChanged"
        :search-options="{
          enabled: true,
          placeholder: $t('Search_this_table'),  
        }"
        :pagination-options="{
        enabled: true,
        mode: 'records',
        nextLabel: 'next',
        prevLabel: 'prev',
      }"
        styleClass="tableOne vgt-table"
      >
        <div slot="selected-row-actions">
          <button class="btn btn-danger" @click="delete_by_selected()">{{ $t('Del') }}</button>
        </div>
        <div slot="table-actions" class="mt-2 mb-3">
 
 
          <b-button @click="Specialneed_Excel()" size="sm" variant="outline-danger m-1">
            <i class="i-File-Excel"></i> EXCEL
          </b-button>
 
          <router-link
            class="btn-sm btn btn-primary btn-icon m-1"
            v-if="currentUserPermissions && currentUserPermissions.includes('specialneeds_add')"
            to="/app/specialneeds/store">
            <span class="ul-btn__icon">
              <i class="i-Add"></i>
            </span>
            <span class="ul-btn__text ml-1">{{ $t('Add') }}</span>
          </router-link>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field == 'actions'">
            <router-link
               
              v-b-tooltip.hover
              title="View"
              :to="{ name:'detail_specialneed', params: { id: props.row.id} }"
            >
              <i class="i-Eye text-25 text-info"></i>
            </router-link>
            <router-link
             
              v-b-tooltip.hover
              title="Edit"
              :to="{ name:'edit_specialneed', params: { id: props.row.id } }">
              <i class="i-Edit text-25 text-success"></i>
            </router-link>

            <a
             
              @click="Remove_Specialneed(props.row.id)"
              v-b-tooltip.hover
              title="Delete" >
              <i class="i-Close-Window text-25 text-danger"></i>
            </a>
          </span>
          <span v-else-if="props.column.field == 'image'">
            <b-img
              thumbnail
              height="50"
              width="50"
              fluid
              :src="'/images/educations/' + props.row.image"
              alt="image"
            ></b-img>
          </span>
        </template>
      </vue-good-table>

      <!-- Multiple filter -->
      <b-sidebar id="sidebar-right" :title="$t('Filter')" bg-variant="white" right shadow>
        <div class="px-3 py-2">
          <b-row>
            <!-- ar_name Specialneed  -->
            <b-col md="12">
              <b-form-group :label="$t('ar_name')">
                <b-form-input
                  label="ar Name Specialneed"
                  :placeholder="$t('SearchByName')"
                  v-model="Filter_ar_name"
                ></b-form-input>
              </b-form-group>
            </b-col>
            <!-- Name  -->
            <b-col md="12">
              <b-form-group :label="$t('En_name')">
                <b-form-input
                  label="en Name Specialneed"
                  :placeholder="$t('SearchByName')"
                  v-model="Filter_en_name"
                ></b-form-input>
              </b-form-group>
            </b-col>

       
  

    

            <b-col md="6" sm="12">
              <b-button
                @click="Get_Specialneeds(serverParams.page)"
                variant="primary m-1"
                size="sm"
                block
              >
                <i class="i-Filter-2"></i>
               {{  $t("Filter") }}
              </b-button>
            </b-col>

            <b-col md="6" sm="12">
              <b-button @click="Reset_Filter()" variant="danger m-1" size="sm" block>
                <i class="i-Power-2"></i>
               {{ $t("Reset") }}
              </b-button>
            </b-col>
          </b-row>
        </div>
      </b-sidebar>

      <!-- Modal Show Import Specialneeds -->
      <b-modal
        ok-only
        ok-title="Cancel"
        size="md"
        id="importSpecialneeds"
        :title="$t('import_specialneeds')">
        <b-form @submit.prevent="Submit_import" enctype="multipart/form-data">
          <b-row>
            <!-- File -->
            <b-col md="12" sm="12" class="mb-3">
              <b-form-group>
                <input type="file" @change="onFileSelected" label="Choose File">
                <b-form-invalid-feedback
                  id="File-feedback"
                  class="d-block"
                >{{$t('field_must_be_in_csv_format')}}</b-form-invalid-feedback>
              </b-form-group>
            </b-col>

             <b-col md="6" sm="12">
            <b-button type="submit" variant="primary" :disabled="ImportProcessing" size="sm" block>{{  $t("submit") }}</b-button>
              <div v-once class="typo__p" v-if="ImportProcessing">
                <div class="spinner sm spinner-primary mt-3"></div>
              </div>
          </b-col>

            <b-col md="6" sm="12">
              <b-button
                :href="'/import/exemples/import_specialneeds.csv'"
                variant="info"
                size="sm"
                block
              >{{  $t("Download_exemple") }}</b-button>
            </b-col>

            <b-col md="12" sm="12">
              <table class="table table-bordered table-sm mt-4">
                <tbody>
                  <tr>
                    <td>{{  $t('en_Name_specialneed') }} </td>
                    <th>
                      <span class="badge badge-outline-success">{{  $t('Field_is_required') }}</span>
                    </th>
                  </tr>

              
                  <tr>
                    <td>{{ $t('ar_Name_specialneed')  }}</td>
                    <th>
                      <span class="badge badge-outline-success">{{  $t('Field_is_required') }}</span>
                    </th>
                  </tr>
     
                </tbody>
              </table>
            </b-col>
          </b-row>
        </b-form>
      </b-modal>
    </div>
  </div>
</template>


<script>
import { mapActions, mapGetters } from "vuex";
import NProgress from "nprogress";
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
  metaInfo: {
    title: "Specialneeds"
  },

  data() {
    return {
      serverParams: {
        sort: {
          field: "id",
          type: "desc"
        },
        page: 1,
        perPage: 10
      },
      selectedIds: [],
      ImportProcessing:false,
      data: new FormData(),
      import_specialneeds: "",
      search: "",
      totalRows: "",
      isLoading: true,
      spinner: false,
      limit: "10",
      Filter_name: "",
      Filter_en_name: "",
      Filter_ar_name: "",
 
      specialneeds: {},
      
 
    };
  },

  computed: {
    ...mapGetters(["currentUserPermissions"]),
    columns() {
      return [
        {
          label: this.$t("image"),
          field: "image",
          type: "image",
          html: true,
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
          label: this.$t("institution"),
          field: "institution",
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
    //-------------------------------------- Specialneeds PDF ------------------------------\
    Specialneed_PDF() {
      var self = this;

      let pdf = new jsPDF("p", "pt");
      let columns = [
        { title: "ar_name", dataKey: "ar_name" },
        { title: "en_name", dataKey: "en_name" },
      ];
      pdf.autoTable(columns, self.specialneeds);
      pdf.text("Specialneed List", 40, 25);
      pdf.save("Specialneed_List.pdf");
    },

    //----------------------------------- Show import specialneeds -------------------------------\
    Show_import_specialneeds() {
      this.$bvModal.show("importSpecialneeds");
    },

    //------------------------------ Event Import specialneeds -------------------------------\
    onFileSelected(e) {
      this.import_specialneeds = "";
      let file = e.target.files[0];
      let errorFilesize;

      if (file["size"] < 1048576) {
        // 1 mega = 1,048,576 Bytes
        errorFilesize = false;
      } else {
        this.makeToast(
          "danger",
          this.$t("file_size_must_be_less_than_1_mega"),
          this.$t("Failed")
        );
      }

      if (errorFilesize === false) {
        this.import_specialneeds = file;
      }
    },

    //----------------------------------------Submit  import specialneeds-----------------\
    Submit_import() {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      var self = this;
      self.ImportProcessing = true;
      self.data.append("specialneeds", self.import_specialneeds);
      axios
        .post("Specialneeds/import/csv", self.data)
        .then(response => {
          self.ImportProcessing = false;
          if (response.data.status === true) {
            this.makeToast(
              "success",
              this.$t("Successfully_Imported"),
              this.$t("Success")
            );
            Fire.$emit("Event_import");
          } else if (response.data.status === false) {
            this.makeToast(
              "danger",
              this.$t("field_must_be_in_csv_format"),
              this.$t("Failed")
            );
          }
          // Complete the animation of theprogress bar.
          NProgress.done();
        })
        .catch(error => {
          self.ImportProcessing = false;
          // Complete the animation of theprogress bar.
          NProgress.done();
          this.makeToast(
            "danger",
            this.$t("Please_follow_the_import_instructions"),
            this.$t("Failed")
          );
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

    //----Update Params Table
    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },

    //---- Event Page Change
    onPageChange({ currentPage }) {
      if (this.serverParams.page !== currentPage) {
        this.updateParams({ page: currentPage });
        this.Get_Specialneeds(currentPage);
      }
    },

    //---- Event Per Page Change
    onPerPageChange({ currentPerPage }) {
      if (this.limit !== currentPerPage) {
        this.limit = currentPerPage;
        this.updateParams({ page: 1, perPage: currentPerPage });
        this.Get_Specialneeds(1);
      }
    },

    //---- Event Select Rows
    selectionChanged({ selectedRows }) {
      this.selectedIds = [];
      selectedRows.forEach((row, index) => {
        this.selectedIds.push(row.id);
      });
    },

    //---- Event Sort Change
    onSortChange(params) {
      let field = "";
      if (params[0].field == "brand") {
        field = "brand_id";
      } else if (params[0].field == "category") {
        field = "category_id";
      } else {
        field = params[0].field;
      }
      this.updateParams({
        sort: {
          type: params[0].type,
          field: field
        }
      });
      this.Get_Specialneeds(this.serverParams.page);
    },

    //---- Event Search
    onSearch(value) {
      this.search = value.searchTerm;
      this.Get_Specialneeds(this.serverParams.page);
    },

    //------ Reset Filter
    Reset_Filter() {
      this.search = "";
      this.Filter_name = "";
       this.Filter_ar_name = "";
       this.Filter_en_name = "";
      this.Get_Specialneeds(this.serverParams.page);
    },

    //------------------------------------ Specialneeds Excel ------------------------------\
    Specialneed_Excel() {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      axios
        .get("Specialneeds/export/Excel", {
          responseType: "blob", // important
          headers: {
            "Content-Type": "application/json"
          }
        })
        .then(response => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "List_Specialneeds.xlsx");
          document.body.appendChild(link);
          link.click();
          // Complete the animation of theprogress bar.
          NProgress.done();
        })
        .catch(() => {
          // Complete the animation of theprogress bar.
          NProgress.done();
        });
    },

    // Simply replaces null values with strings=''
    setToStrings() {
 
    },

    //----------------------------------- Get All Specialneeds ------------------------------\
    Get_Specialneeds(page) {
      // Start the progress bar.
      NProgress.start();
      NProgress.set(0.1);
      this.setToStrings();
      axios
        .get(
          "Specialneeds?page=" +
            page +
            "&en_name=" +
            this.Filter_en_name +
            "&ar_name=" +
            this.Filter_ar_name +
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
          this.specialneeds = response.data.specialneeds;
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

    //----------------------------------- Remove Specialneed ------------------------------\
    Remove_Specialneed(id) {
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
            .delete("Specialneeds/" + id)
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.SpecialneedDeleted"),
                "success"
              );

              Fire.$emit("Delete_Specialneed");
            })
            .catch(() => {
              // Complete the animation of theprogress bar.
              setTimeout(() => NProgress.done(), 500);
              this.$swal(
                this.$t("Delete.Failed"),
                this.$t("Delete.AlreadyLinked"),
                "warning"
              );
            });
        }
      });
    },

    //---- Delete specialneeds by selection
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
            .post("Specialneeds/delete/by_selection", {
              selectedIds: this.selectedIds
            })
            .then(() => {
              this.$swal(
                this.$t("Delete.Deleted"),
                this.$t("Delete.SpecialneedDeleted"),
                "success"
              );

              Fire.$emit("Delete_Specialneed");
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

  //-----------------------------Created function-------------------

  created: function() {
    this.Get_Specialneeds(1);

    Fire.$on("Delete_Specialneed", () => {
      this.Get_Specialneeds(this.serverParams.page);
      // Complete the animation of theprogress bar.
      setTimeout(() => NProgress.done(), 500);
    });

    Fire.$on("Event_import", () => {
      setTimeout(() => {
        this.Get_Specialneeds(this.serverParams.page);
        this.$bvModal.hide("importSpecialneeds");
      }, 500);
    });
  }
};
</script>