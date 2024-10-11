import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import 'primeicons/primeicons.css'; 
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup'; 
import Row from 'primevue/row';  
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';
import Dialog  from 'primevue/dialog';
import Layout from './Pages/Layouts/Layout.vue'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    let page =  pages[`./Pages/${name}.vue`];

    if(name == 'Auth/Register' || name == 'Auth/Login'){
      page.default.layout = page.default.layout;
    }else{
      page.default.layout = Layout;
    }
    
    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
        .use(PrimeVue, {
            theme: {
                preset: Aura
            }
        })
      .use(plugin)
      .component('IconField',IconField)
      .component('InputIcon',InputIcon)
      .component('InputText',InputText)
      .component('DataTable',DataTable)
      .component('Column',Column)
      .component('ColumnGroup',ColumnGroup)
      .component('Row',Row)
      .component('InputNumber',InputNumber)
      .component('Button',Button)
      .component('Dialog',Dialog)
      .mount(el)
  },
})