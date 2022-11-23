<template>
  <div>testtest</div>
</template>

<script>
export default {
  props: {
    url: String,
  },
  data() {
    return {
      columns: [
        {
          label: 'First Name',
          name: 'first_name',
          orderable: true,
        },
        {
          label: 'Last Name',
          name: 'last_name',
          orderable: true,
        },
        {
          label: 'Phone',
          name: 'phone',
          orderable: true,
        },
        {
          label: 'Email',
          name: 'email',
          orderable: true,
        },
        {
          label: 'Club',
          name: 'club',
          orderable: true,
        },
      ],
    }
  },
  mounted(){
    console.log(this.url);
  }
}
</script>

<style scoped>

</style>