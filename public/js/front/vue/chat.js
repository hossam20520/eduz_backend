// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBAo-9uGF0imkowHLWaZw6ZAfdHn18YhkI",
  authDomain: "eduz-add95.firebaseapp.com",
  projectId: "eduz-add95",
  storageBucket: "eduz-add95.appspot.com",
  messagingSenderId: "634601617248",
  appId: "1:634601617248:web:0792d0428eff9686c4d005",
  measurementId: "G-24381Q9R73"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Access Firestore (optional if you need to use the Firestore database)
const db = firebase.firestore();

const i18n = new VueI18n({
  locale: "en", // Set the default locale
  messages: {
    en: {
      hello: "Hello",
      Items: "Items",
    },
    fr: {
      hello: "Bonjour",
      Items: "Items",
    },
  },
});

new Vue({
  el: "#appp",
  i18n,
  data: {
    showChat: true,
    load: true,
    user_id: 0,
    image: "",
    name: "",
    user:"",
    private: false,
    receiver_id: 0,
    from_to: "",
    color: "HSL(45,100%,50%)",
    messages: [],
    newMessage: "",
    local: "en",
    cart: [],

    baseUrl: "",
  },
  mounted() {
    this.local = this.$i18n.locale;
    var baseUrl = window.location.protocol + "//" + window.location.host + "/";
    this.baseUrl = baseUrl;
    const urlParams = new URLSearchParams(window.location.search);

    if(urlParams.has("token")){
      const token = urlParams.get("token");
      this.getProfileData(token);

      





    }


 

    if (this.private) {
  
      db.collection("chats")
        .doc(this.from_to)
        .collection("messages")
        .orderBy("time")
        .onSnapshot((snapshot) => {
          snapshot.docChanges().forEach((change) => {
            if (change.type === "added") {
              const newMessage = change.doc.data();
              this.messages.push(newMessage);
              this.$nextTick(() => {
                this.$refs.chatMessages.scrollTop =
                  this.$refs.chatMessages.scrollHeight;
              });
            }
          });
        });

 
    } 




  },
  methods: {
    close() {
      this.showChat = false;
    },
    sendMessage() {
      var newMessage = {};
    
        newMessage = {
          who: "justify-content-end mb-4 pt-1",
          time: Date.now(),
          username: "You",
          id: this.user_id,
          name: this.name,
          to: this.receiver_id,
          image: this.image,
          text: this.newMessage,
        };
      
 

        db.collection("chats")
          .doc(this.from_to)
          .collection("messages")
          .add(newMessage)
          .then(() => {
            //   this.messages.push(newMessage);
            this.newMessage = "";

            this.$nextTick(() => {
              this.$refs.chatMessages.scrollTop =
                this.$refs.chatMessages.scrollHeight;
            });
          })
          .catch((error) => {
            console.error("Error adding message to Firestore: ", error);
          });

       
          const user = {
            to: this.receiver_id,
            time: Date.now(),
            username: "You",
            id: this.user_id,
            name: this.name,
            image: this.image,
            text: this.newMessage,
          };




          db.collection("users")
            .add(user)
            .then(() => {
              //   this.messages.push(newMessage);
              // this.newMessage = '';
              // this.$nextTick(() => {
              //   this.$refs.chatMessages.scrollTop = this.$refs.chatMessages.scrollHeight;
              // });
            })
            .catch((error) => {
              console.error("Error adding message to Firestore: ", error);
            });
      
 
    },

  
    getProfileData(token){
 
      axios.get('/api/device/auth/user' , {
          headers: {
              'Authorization': 'Bearer  ' + token
          }
      }).then(
              response => {

                  this.user = response.data.user;
                  this.user_id =   response.data.user.id;

                
                  const image =  response.data.user.avatar;
                  const name = response.data.user.firstname + " "+response.data.user.lastname;
                  this.name = name;
                  this.image = this.baseUrl + "images/avatar/" + image;
                 

                  const urlParamsa = new URLSearchParams(window.location.search);

                  if (urlParamsa.has("user_id")) {
                    // Get the value of the user_id parameter
                    const userId = urlParamsa.get("user_id");
                    this.private = true;
                    this.receiver_id = userId;
                    // Check if the 'replay' parameter exists in the current URL
                    if (urlParamsa.has("replay")) {
                      this.from_to =  userId+"-" +  this.user_id;
                     
                    } else {
                      this.from_to = this.user_id + "-" + userId;     
                    }
             
                  } 
           
              })
          .catch(error => {
              console.error(error);
          });


  },
 
    
  },
});
