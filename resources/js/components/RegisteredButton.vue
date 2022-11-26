<template>
    <div class="row mt-4" v-if="showDiv" data-html2canvas-ignore="true">
        <div class="col-md-12 text-center" >
            <a :href="'/registered/'+registration_id+'/dlqr'" class="btn btn-lg btn-primary me-lg-4 mb-2">Download QR Code</a>
            <a href="javascript:void(0);" @click="downloadReceipt" class="btn btn-lg btn-primary ms-lg-4 mb-2">Download PDF</a>
        </div>
    </div>
</template>

<script>
import html2pdf from 'html2pdf.js'

export default {
    name: 'RegisteredButton',
    props: {
      registration_id: String,
    },
    methods: {
        downloadReceipt() {
            var opt = {
                margin:       0.5,
                filename:     'agala-registration-receipt.pdf',
                image:        { type: 'jpeg', quality: 1 },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'], avoid: '.page-break-avoid' },
                html2canvas:  { scale: 1,  windowWidth: 1366 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            this.showDiv = false;
            setTimeout(function () {
                var element = document.getElementById('capture');
                var buttons = document.getElementById('registeredButtons');
                html2pdf().set(opt).from(element).save();
            }, 1500)
            this.showDiv = true;
        },
    },
    data(){
        return {
            showDiv: true
        }
    },
    mounted() {

    }
}
</script>
