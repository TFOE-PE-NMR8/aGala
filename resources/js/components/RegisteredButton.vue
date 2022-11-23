<template>
    <div class="row mt-4" v-show="!hideDiv">
        <div class="col text-center">
            <a href="javascript:void(0);" class="btn btn-primary me-md-4">Download QR Code</a>
            <a href="javascript:void(0);" @click="downloadReceipt" class="btn btn-primary ms-md-4 mt-sm-4">Download Receipt</a>
        </div>
    </div>
</template>

<script>
import html2pdf from 'html2pdf.js'

export default {
    name: 'RegisteredButton',
    methods: {
        downloadReceipt() {
            var opt = {
                margin:       0.5,
                filename:     'receipt.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { scale: 1 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            this.hideDiv = true;
            var element = document.getElementById('capture');
            html2pdf().set(opt).from(element).save();
            this.hideDiv = false;
        },
    },
    data(){
        return {
            hideDiv: false
        }
    },
    mounted() {

    }
}
</script>
