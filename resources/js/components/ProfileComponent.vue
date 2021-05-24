<template>
  <div>
    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label> 
      <div class="col-md-6">
        <input id="email" type="email" v-model="userData.email" name="email" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
      </div>
    </div> 

    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">Name</label> 
      <div class="col-md-6">
        <input id="email" type="text" name="email" v-model="userData.name" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
      </div>
    </div> 

    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">Password</label> 
      <div class="col-md-6">
        <input id="email" type="password" name="password" v-model="userData.password" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
      </div>
    </div> 

    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">Confirm Password</label> 
      <div class="col-md-6">
        <input id="email" type="password" name="confirm_password" v-model="userData.confirm_password" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
      </div>
    </div> 
    <hr />
    <button class="btn-primary" @click="save">Save</button>
  </div>
</template>

<script>
  export default {
    props: [
      'modalTitle',
      'roles',
      'action'
    ],
    data() {
      return {
        userData: {}
      }
  },
    methods: {

      save(){
        axios.put('/profile/', this.userData).then(function (res) {
            console.log(res)
            this.$emit('closeAndRefreshTable');
          }.bind(this));
      },

      getUserInfo() {
          let self = this;
          self.modalTitle = "Update User";
          self.action = 'update';
          axios.get('/profile/info').then(function (res) {
              self.isModalVisible = true;
              self.userData = res.data;
          }.bind(this));
          
      },
    },

    created: function () {
      window.vueComponent = this;
      this.getUserInfo();
    }
  };
</script>