<template>
  <div class="row">
    <div class="m-auto col-lg-8">
      <card title="Reset password">
        <form @submit.prevent="send" @keydown="form.onKeydown($event)">
          <alert-success :form="form" :message="status" />

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">
                Send password reset link
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
export default {
  middleware: 'guest',
  metaInfo () {
    return { title: 'Reset password' }
  },
  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),
  methods: {
    async send () {
      const { data } = await this.form.post('/api/password/email')
      this.status = data.status
      this.form.reset()
    }
  }
}
</script>
