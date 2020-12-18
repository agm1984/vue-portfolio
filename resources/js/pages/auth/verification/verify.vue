<template>
  <div class="row">
    <div class="m-auto col-lg-8">
      <card title="Verify email">
        <template v-if="success">
          <div class="alert alert-success" role="alert">
            {{ success }}
          </div>

          <router-link :to="{ name: 'login' }" class="btn btn-primary">
            Login
          </router-link>
        </template>
        <template v-else>
          <div class="alert alert-danger" role="alert">
            {{ error || 'Failed to verify email' }}
          </div>

          <router-link :to="{ name: 'verification.resend' }" class="float-right small">
            Resend verification link
          </router-link>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')
export default {
  middleware: 'guest',
  metaInfo () {
    return { title: 'Verify email' }
  },
  async beforeRouteEnter (to, from, next) {
    try {
      const { data } = await axios.post(`/api/email/verify/${to.params.id}?${qs(to.query)}`)
      next(vm => { vm.success = data.status })
    } catch (e) {
      next(vm => { vm.error = e.response.data.status })
    }
  },
  data: () => ({
    error: '',
    success: ''
  })
}
</script>
