
<template>
  <div class="main-content">
    <breadcumb :page="$t('TeacherDetails')" :folder="$t('Teachers')"/>
    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <b-card no-body v-if="!isLoading">
      <b-card-header>
        <button @click="print_teacher()" class="btn btn-outline-primary">
          <i class="i-Billing"></i>
          {{  $t('print') }}
        </button>
      </b-card-header>
      <b-card-body>
        <b-row id="print_teacher">
  

          <b-col md="8">
            <table class="table table-hover table-bordered table-md">
              <tbody>
                <tr>
                  <td> {{  $t('ar_name') }}</td>
                  <th> {{  teacher.ar_name  }}</th>
                </tr>
                <tr>
                  <td> {{  $t('en_name')  }}</td>
                  <th> {{  teacher.en_name   }}</th>
                </tr>


                <tr>
                  <td> {{  $t('ar_country')  }}</td>
                  <th> {{  teacher.ar_country   }}</th>
                </tr>


                <tr>
                  <td> {{  $t('en_country')  }}</td>
                  <th> {{  teacher.en_country   }}</th>
                </tr>



                <tr>
                  <td> {{  $t('en_subject')  }}</td>
                  <th> {{  teacher.en_subject   }}</th>
                </tr>



                <tr>
                  <td> {{  $t('ar_subject')  }}</td>
                  <th> {{  teacher.ar_subject   }}</th>
                </tr>





                <tr>
                  <td> {{  $t('age_from')  }}</td>
                  <th> {{  teacher.age_from   }}</th>
                </tr>


                <tr>
                  <td> {{  $t('age_to')  }}</td>
                  <th> {{  teacher.age_to   }}</th>
                </tr>


                <tr>
                  <td> {{  $t('share')  }}</td>
                  <th> {{  teacher.share   }}</th>
                </tr>

                <tr>
                  <td> {{  $t('ar_about')  }}</td>
                  <th v-html="ar_about"> </th>
                </tr>


                <tr>
                  <td> {{  $t('en_about')  }}</td>
                  <th v-html="en_about"> </th>
                </tr>
 
              </tbody>
            </table>
          </b-col>
          <b-col md="4" class="mb-30">
            <div class="carousel_wrap">
              <b-carousel
                id="carousel-1"
                :interval="2000"
                controls
                background="#ababab"
                img-width="1024"
                img-height="480"
                @sliding-start="onSlideStart"
                @sliding-end="onSlideEnd"
              >
                <b-carousel-slide
                  v-for="(image, index) in teacher.images"
                  :key="index"
                  :img-src="'/images/teachers/'+image"
                ></b-carousel-slide>
              </b-carousel>
            </div>
          </b-col>

          <!-- Warehouse Quantity -->
          <b-col md="5" class="mt-4">
            <table class="table table-hover table-sm">
          
     
            </table>
          </b-col>
          <!-- Warehouse Variants Quantity -->
  
        </b-row>
      </b-card-body>
    </b-card>
  </div>
</template>


<script>
import VueBarcode from "vue-barcode";
import { mapActions, mapGetters } from "vuex";

export default {
  metaInfo: {
    title: "Detail Teacher"
  },
  components: {
    barcode: VueBarcode
  },

  data() {
    return {
      len: 8,
      images: [],
      imageArray: [],
      isLoading: true,
      teacher: {},
      roles: {},
      variants: []
    };
  },
  computed: {
    ...mapGetters(["currentUser"])
  },

  methods: {
    //------- printteacher
    print_teacher() {
      var divContents = document.getElementById("print_teacher").innerHTML;
      var a = window.open("", "", "height=500, width=500");
      a.document.write(
        '<link rel="stylesheet" href="/assets_setup/css/bootstrap.css"><html>'
      );
      a.document.write("<body >");
      a.document.write(divContents);
      a.document.write("</body></html>");
      a.document.close();
      a.print();
    },

    //------------------------------Formetted Numbers -------------------------\
    formatNumber(number, dec) {
      const value = (typeof number === "string"
        ? number
        : number.toString()
      ).split(".");
      if (dec <= 0) return value[0];
      let formated = value[1] || "";
      if (formated.length > dec)
        return `${value[0]}.${formated.substr(0, dec)}`;
      while (formated.length < dec) formated += "0";
      return `${value[0]}.${formated}`;
    },

    //----------------------------------- Get Details Teacher ------------------------------\
    showDetails() {
      let id = this.$route.params.id;
      axios
        .get(`Teachers/Detail/${id}`)
        .then(response => {
          this.teacher = response.data;
          this.isLoading = false;
        })
        .catch(response => {
          setTimeout(() => {
            this.isLoading = false;
          }, 500);
        });
    }
  }, //end Methods

  //-----------------------------Created function-------------------

  created: function() {
    this.showDetails();
  }
};
</script>