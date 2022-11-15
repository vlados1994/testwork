<template>
    <div class="container">
        <div class="row justify-content-center appointment">
            <div class="appointment__title">
                Запись на прием к дантисту
            </div>
            <v-form
                class="appointment__form"
                ref="form"
                v-model="valid"
            >
                <v-container>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-select
                                label="Специалист"
                                v-model="dentist"
                                :rules="dentistRules"
                                item-title="name"
                                item-value="id"
                                :items="dentists"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-select
                                label="Услуга"
                                v-model="service"
                                :rules="serviceRules"
                                item-title="name"
                                item-value="id"
                                :items="services"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row v-if="dentist && service">
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <Datepicker v-model="date"/>
                        </v-col>
                    </v-row>
                    <v-row
                        v-if="date"
                        class="appointment__hours"
                    >
                        <v-col
                            class="appointment__hour"
                            v-for="hour in [8, 9, 10, 11, 12]"
                            cols="12"
                            md="12"
                            :style="{
                                border: inSchedule(hour) ? '3px solid green' : '3px solid red',
                                cursor: inSchedule(hour) ? 'auto' : 'pointer',
                            }"
                            @click="selectHour(hour)"
                        >
                            {{ hour }}:00 - {{ hour + 1 }}:00
                        </v-col>
                    </v-row>
                    <v-row v-if="dentist && service && date && hour">
                        <v-responsive
                            class="mx-auto appointment__btn"
                            max-width="220"
                        >
                            <v-btn
                                color="success"
                                @click="send"
                            >
                                Записаться на прием
                            </v-btn>
                        </v-responsive>
                    </v-row>
                </v-container>
            </v-form>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    data: () => ({
        valid: false,
        dentist: '',
        dentists: [],
        dentistRules: [
            v => !!v || 'Dentist is required',
        ],
        service: '',
        services: [],
        serviceRules: [
            v => !!v || 'Service is required',
        ],
        date: '',
        dateRules: [
            v => !!v || 'Service is required',
        ],
        hour: '',
        schedules: [],
    }),
    async mounted() {
        this.dentists = await this.getUsers('dentist');

        this.services = await this.getServices();
    },
    watch: {
        date(val) {
            if (val) {
                this.schedules = this.getSchedules({dentist: this.dentist, date: this.date});
            }
        }
    },
    methods: {
        ...mapActions([
            'getServices',
            'getUsers',
            'getSchedules',
        ]),
        inSchedule(hour) {
            const result = this.schedules.find(element => element.hour === hour);

            return result !== undefined;
        },
        async send() {
            const response = await axios.post('/api/schedules', {
                dentist_id: this.dentist,
                service_id: this.service,
                date: this.date,
                hour: this.hour,
            });

            this.schedules = await this.getSchedules({dentist: this.dentist, date: this.date});
        },

        async selectHour(hour) {
            if (!this.inSchedule(hour)) {
                this.hour = hour;
            }
        },
    },
}
</script>

<style>
.appointment {
    flex-direction: column;
    align-items: center;
}

.appointment__title {
    width: auto;
    font-weight: bold;
    font-size: 20px;
    margin-top: 50px;
}

.appointment__form {
    width: 500px;
    margin-top: 30px;
}

.appointment__btn {
    margin-top: 30px;
}

.appointment__hours {
    margin-top: 30px;
}

.appointment__hour {
    border: 3px solid red;
    margin-bottom: 5px;
}
</style>
