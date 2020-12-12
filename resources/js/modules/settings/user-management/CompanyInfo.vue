<template>
  <div>
    <div class="row">
      <div class="col-4">
        <input
          type="file"
          id="companyLogoImage"
          name="companyLogoImage"
          class="dropify-fr"
          data-height="150"
        />
      </div>
      <div class="col-8">
        <h4 class="font-weight-bold mb-1"></h4>
        <p class="account-number mb-2">
          Account no
          <span>12345678</span>
        </p>
        <div class="d-flex tab-row-label">
          <label class="language min-width-220 align-self-center">language</label>
          <select class data-size="5" data-width="fit">
            <option v-for="language in languages" :key="language">{{ language }}</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <h5 class="font-weight-bold">Companies house</h5>
      </div>
      <div class="col-4">
        <label class="Registered-Number">Registered Number</label>
      </div>
      <div class="col-4">
        <p>fsfsdf</p>
        <a href="javascript:void(0);" class="Verify" @click="verifyCompanyNumber">Verify</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["company"],
  data: {
    languages: ["English (UK)", "Español", "English (USA)", "French", "German"],
  },
  methods: {
    verifyCompanyNumber: function () {},
  },
};
</script>
