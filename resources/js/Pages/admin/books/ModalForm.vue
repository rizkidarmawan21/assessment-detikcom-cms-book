<script setup>
import axios from "axios";
import { ref } from "vue";
import { bool, object } from "vue-types";
import { notify } from "notiwind";
import VDialog from "@/components/VDialog/index.vue";
import VButton from "@/components/VButton/index.vue";
import VSelect from "@/components/VSelect/index.vue";
import VInput from "@/components/VInput/index.vue";
import VTextarea from "@/components/VTextarea/index.vue";

const props = defineProps({
    openDialog: bool(),
    updateAction: bool().def(false),
    data: object().def({}),
    additional: object().def({}),
});

const emit = defineEmits(["close", "successSubmit"]);

const isLoading = ref(false);
const formError = ref({});
const form = ref({});
const previewImage = ref('')
const previewPDF = ref('')

const openForm = () => {
    if (props.updateAction) {
        form.value = Object.assign(form.value, props.data);
        previewImage.value = props.data.path + props.data.cover_file;
        previewPDF.value = props.data.pdf_file;
    } else {
        form.value = ref({});
    }
};



const closeForm = () => {
    form.value = ref({});
    formError.value = ref({});

    if (document.getElementById("cover")) {
        document.getElementById("cover").value = null
    }
    previewImage.value = ''

    if (document.getElementById("file")) {
        document.getElementById("file").value = null
    }
};

const fileSelected = (evt) => {
    formError.value.cover = ''
    form.value.cover = evt.target.files[0];
    previewImage.value = URL.createObjectURL(evt.target.files[0]);
}

const DigitalFileSelected = (evt) => {
    formError.value.file = ''
    form.value.file = evt.target.files[0];
}


const submit = async () => {
    const fd = new FormData();
    Object.keys(form.value).forEach(key => {
        fd.append(key, form.value[key]);
    })

    props.updateAction ? update(fd) : create(fd)
}

const update = async () => {
    isLoading.value = true;
    axios
        .post(
            route("books.update-data", { id: props.data.id }),
            form.value
        )
        .then((res) => {
            emit("close");
            emit("successSubmit");
            form.value = ref({});
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
        })
        .catch((res) => {
            // Handle validation errors
            const result = res.response.data;
            const metaError = res.response.data.meta?.error;
            if (result.hasOwnProperty("errors")) {
                formError.value = ref({});
                Object.keys(result.errors).map((key) => {
                    formError.value[key] = result.errors[key].toString();
                });
            }

            if (metaError) {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: metaError,
                    },
                    2500
                );
            } else {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: result.message,
                    },
                    2500
                );
            }
        })
        .finally(() => (isLoading.value = false));
};

const create = async (fd) => {
    isLoading.value = true;
    console.log(fd)
    axios
        .post(route("books.create-data"), fd)
        .then((res) => {
            emit("close");
            emit("successSubmit");
            form.value = ref({});
            notify(
                {
                    type: "success",
                    group: "top",
                    text: res.data.meta.message,
                },
                2500
            );
        })
        .catch((res) => {
            // Handle validation errors
            const result = res.response.data;
            const metaError = res.response.data.meta?.error;
            if (result.hasOwnProperty("errors")) {
                formError.value = ref({});
                Object.keys(result.errors).map((key) => {
                    formError.value[key] = result.errors[key].toString();
                });
            }

            if (metaError) {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: metaError,
                    },
                    2500
                );
            } else {
                notify(
                    {
                        type: "error",
                        group: "top",
                        text: result.message,
                    },
                    2500
                );
            }
        })
        .finally(() => (isLoading.value = false));
};
</script>

<template>
    <VDialog
        :showModal="openDialog"
        :title="updateAction ? 'Update Book' : 'Add Book'"
        @opened="openForm"
        @closed="closeForm"
        size="xl"
    >
        <template v-slot:close>
            <button
                class="text-slate-400 hover:text-slate-500"
                @click="$emit('close')"
            >
                <div class="sr-only">Close</div>
                <svg class="w-4 h-4 fill-current">
                    <path
                        d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z"
                    />
                </svg>
            </button>
        </template>
        <template v-slot:content>
            <div class="grid grid-cols-2 gap-3">
                <VInput
                    placeholder="Insert Title"
                    label="Title"
                    :required="true"
                    v-model="form.title"
                    :errorMessage="formError.title"
                    @update:modelValue="formError.title = ''"
                />
                <VInput
                    placeholder="Insert Number of Page"
                    label="Number of Page"
                    :required="true"
                    v-model="form.number_of_pages"
                    :errorMessage="formError.number_of_pages"
                    @update:modelValue="formError.number_of_pages = ''"
                    type="number"
                />
                <div class="col-span-2">
                    <VSelect
                        placeholder="Choose Category"
                        :required="true"
                        v-model="form.category_id"
                        :options="additional.book_category_list"
                        label="Category"
                        :errorMessage="formError.category_id"
                        @update:modelValue="formError.category_id = ''"
                    />
                </div>
                <div class="col-span-2">
                    <VTextarea
                        placeholder="Input Description"
                        label="Description"
                        :required="true"
                        v-model="form.description"
                        :errorMessage="formError.description"
                        @update:modelValue="formError.description = ''"
                    />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-600 mb-1" for="cover">
                        Book Cover
                        <span class="text-rose-500" v-if="!updateAction">*</span>
                    </label>

                    <img class="h-32 mb-1" :src="previewImage" v-if="previewImage" />
                    <input class="block w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md"
                        type="file" id="cover" accept=".jpg, .jpeg, .png" @change="fileSelected">
                    <div class="text-xs mt-1" 
                        :class="[{
                            'text-rose-500': formError.cover
                        }]" v-if="formError.cover">
                        {{ formError.cover }}
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-600 mb-1" for="file">
                        Digital File (PDF)
                        <!-- <span class="text-rose-500" v-if="updateAction">*</span> -->
                    </label>
                     <div v-if="previewPDF" class="my-4">
                        <a
                        :href="form.path + previewPDF"
                        target="_blank"
                        class=" bg-sky-400 text-white py-1 px-2 rounded-xl hover:bg-sky-500"
                        >Preview old file</a>
                     </div>
                    <input class="block w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md"
                        type="file" id="file" accept=".pdf" @change="DigitalFileSelected">
                    <div class="text-xs mt-1" 
                        :class="[{
                            'text-rose-500': formError.file
                        }]" v-if="formError.file">
                        {{ formError.file }}
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <div class="flex flex-wrap justify-end space-x-2">
                <VButton
                    label="Cancel"
                    type="default"
                    @click="$emit('close')"
                />
                <VButton
                    :is-loading="isLoading"
                    :label="updateAction ? 'Update' : 'Create'"
                    type="primary"
                    @click="submit"
                />
            </div>
        </template>
    </VDialog>
</template>
