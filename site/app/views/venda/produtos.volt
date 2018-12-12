<v-stepper v-model="passo" vertical>
    <v-stepper-step step="1" complete>
        Informações Básicas do Produto
    </v-stepper-step>

    <v-stepper-content step="1">
        <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card>
        <v-btn color="primary" @click="passo = 2">Continue</v-btn>
        <v-btn flat>Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="2" complete>Name of step 2</v-stepper-step>

    <v-stepper-content step="2">
        <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card>
        <v-btn color="primary" @click="passo = 3">Continue</v-btn>
        <v-btn flat>Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step :rules="[() => false]" step="3">
        Ad templates
        <small>Alert message</small>
    </v-stepper-step>

    <v-stepper-content step="3">
        <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card>
        <v-btn color="primary" @click="passo = 4">Continue</v-btn>
        <v-btn flat>Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="4">View setup instructions</v-stepper-step>

    <v-stepper-content step="4">
        <v-card color="grey lighten-1" class="mb-5" height="200px"></v-card>
        <v-btn color="primary" @click="passo = 1">Continue</v-btn>
        <v-btn flat>Cancel</v-btn>
    </v-stepper-content>
</v-stepper>

{% set templateAfter = 'venda/produto_js_after' %}