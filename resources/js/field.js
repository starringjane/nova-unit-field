import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting((app, store) => {
    app.component('index-unit-field', IndexField);
    app.component('detail-unit-field', DetailField);
    app.component('form-unit-field', FormField);
});
