<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header
          class="modal-header"
          id="modalTitle"
        >
          <slot name="header">
            <h3>{{ modalTitle }}</h3>
          </slot>
          <button
            type="button"
            class="btn-close"
            @click="close"
            aria-label="Close modal"
          >
            x
          </button>
        </header>

        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div id="forCreateAndUpdate" v-show="action != 'delete'">
                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label> 
                  <div class="col-md-6">
                    <input id="email" type="email" v-model="userData.email" name="email" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
                  </div>
                </div> 

                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">Name</label> 
                  <div class="col-md-6">
                    <input id="email" type="email" name="email" v-model="userData.name" required="required" autocomplete="email" autofocus="autofocus" class="form-control ">
                  </div>
                </div> 
                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">Role</label> 
                  <div class="col-md-6">
                    <select class="form-control" v-model="userData.role_id">
                      <option v-for="n in roles" :value="n.id" :selected="n.id == userData.role_id">{{n.name}}</option>
                    </select>
                  </div>
                </div> 
            </div>
            <div id="forDelete" v-show="action == 'delete'" style="text-align: center;">
              <h4>Are you sure you want to delete this user?</h4>
            </div>
          </slot>
        </section>

        <footer class="modal-footer">
          <button
            type="button"
            class="btn-secondary btn-sm"
            @click="close"
            aria-label="Close modal"
          >
            Cancel
          </button>
          <button
            type="button"
            class="btn-primary btn-sm"
            @click="save"
            v-show="action != 'delete'"
          >
            Save
          </button>
          <button
            type="button"
            class="btn-danger btn-sm"
            @click="deleteFn"
            v-show="action == 'delete'"
          >
            Delete
          </button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal {
    position: relative !important;
    width: 70%;
    height: auto;
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    justify-content: space-between;
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: row;
    justify-content: center;
  }

  .modal-body {
    position: relative;
    padding: 20px 10px;
    flex: none;
  }

  .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4AAE9B;
    background: transparent;
  }

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }
</style>

<script>
  export default {
    name: 'Modal',
    props: [
      'userData',
      'modalTitle',
      'roles',
      'action'
    ],
    methods: {
      close() {
        this.$emit('close');
      },

      save(){
        if(this.$props.action == 'create'){
          axios.post('users', this.$props.userData).then(function (res) {
            console.log(res)
            snackAlert('You\'ve successfully added a user');
            this.$emit('closeAndRefreshTable');
          }.bind(this))
          .catch(err => {
            if(err.response.status == 422){
              let data = err.response.data.errors;
              snackAlert(data[Object.keys(data)[0]], 'danger', 'Error');
            }
          });
        }else if(this.$props.action == 'update'){
          axios.put('users/'+this.$props.userData.id, this.$props.userData).then(function (res) {
            snackAlert('You\'ve successfully updated a user');
            console.log(res)
            this.$emit('closeAndRefreshTable');
          }.bind(this))
          .catch(err => {
            if(err.response.status == 422){
              let data = err.response.data.errors;
              snackAlert(data[Object.keys(data)[0]], 'danger', 'Error');
            }
          });
        }
      },

      deleteFn(){
        axios.delete('users/'+this.$props.userData.id, this.$props.userData).then(function (res) {
            console.log(res)
            this.$emit('closeAndRefreshTable');
            snackAlert('You\'ve successfully deleted a user');
          }.bind(this));
      }
    },
  };
</script>