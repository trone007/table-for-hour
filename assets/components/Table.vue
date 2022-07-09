<template>
  <div @click="onClick()" :style="style">

    <svg class="table" v-bind:class="{'--booked': occupied,  }" width="110" height="127" viewBox="0 0 110 127" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="0.5" y="0.5" width="94" height="126" rx="0.5" fill="white" stroke="#666666"/>
      <path d="M30.433 104.087L16.933 80.7044C16.0514 79.1774 16.4512 77.2622 17.7988 76.204L34.7634 105.587C33.1732 106.225 31.3146 105.614 30.433 104.087Z" fill="white" stroke="#666666"/>
      <path d="M39.1649 115.211L11.1649 66.714C10.2833 65.187 10.6831 63.2718 12.0307 62.2136L43.4953 116.712C41.9051 117.35 40.0466 116.738 39.1649 115.211Z" fill="white" stroke="#666666"/>
      <rect x="39.9772" y="102.618" width="35" height="11" rx="0.5" transform="rotate(-120 39.9772 102.618)" fill="white" stroke="#666666"/>
      <rect x="39.1602" y="100.203" width="1" height="9" transform="rotate(-120 39.1602 100.203)" fill="#D9D9D9"/>
      <rect x="45.5884" y="95.3371" width="1" height="2" transform="rotate(-120 45.5884 95.3371)" fill="#D9D9D9"/>
      <rect x="42.0884" y="89.2749" width="1" height="2" transform="rotate(-120 42.0884 89.2749)" fill="#D9D9D9"/>
      <rect x="36.0884" y="78.8826" width="1" height="2" transform="rotate(-120 36.0884 78.8826)" fill="#D9D9D9"/>
      <rect x="33.0884" y="73.6864" width="1" height="2" transform="rotate(-120 33.0884 73.6864)" fill="#D9D9D9"/>
      <rect x="24.8923" y="71.4903" width="1" height="34" transform="rotate(-30 24.8923 71.4903)" fill="#D9D9D9"/>
      <rect x="27.4905" y="69.9903" width="1" height="34" transform="rotate(-30 27.4905 69.9903)" fill="#D9D9D9"/>
      <rect x="30.0884" y="68.4903" width="1" height="34" transform="rotate(-30 30.0884 68.4903)" fill="#D9D9D9"/>
      <rect x="37.6602" y="97.605" width="1" height="9" transform="rotate(-120 37.6602 97.605)" fill="#D9D9D9"/>
      <rect x="36.1602" y="95.007" width="1" height="9" transform="rotate(-120 36.1602 95.007)" fill="#D9D9D9"/>
      <rect x="34.6602" y="92.4089" width="1" height="9" transform="rotate(-120 34.6602 92.4089)" fill="#D9D9D9"/>
      <rect x="33.1602" y="89.8108" width="1" height="9" transform="rotate(-120 33.1602 89.8108)" fill="#D9D9D9"/>
      <rect x="31.6602" y="87.2127" width="1" height="9" transform="rotate(-120 31.6602 87.2127)" fill="#D9D9D9"/>
      <rect x="30.1602" y="84.6147" width="1" height="9" transform="rotate(-120 30.1602 84.6147)" fill="#D9D9D9"/>
      <rect x="28.6602" y="82.0166" width="1" height="9" transform="rotate(-120 28.6602 82.0166)" fill="#D9D9D9"/>
      <rect x="27.1602" y="79.4185" width="1" height="9" transform="rotate(-120 27.1602 79.4185)" fill="#D9D9D9"/>
      <rect x="25.6602" y="76.8204" width="1" height="9" transform="rotate(-120 25.6602 76.8204)" fill="#D9D9D9"/>
      <rect x="24.1602" y="74.2223" width="1" height="9" transform="rotate(-120 24.1602 74.2223)" fill="#D9D9D9"/>
      <rect x="106.5" y="33.5" width="3" height="45" rx="1.5" fill="white" stroke="#666666"/>
      <path d="M103.5 42.4286V69.5714C103.5 74.5025 99.5025 78.5 94.5714 78.5C94.532 78.5 94.5 78.468 94.5 78.4286V33.5714C94.5 33.532 94.532 33.5 94.5714 33.5C99.5025 33.5 103.5 37.4975 103.5 42.4286Z" fill="white" stroke="#666666"/>
    </svg>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    desk: Object,
    width: Number,
    length: Number,
    x: Number,
    y: Number,
    rotation: Number,
    occupied: Boolean
  },
  data()
  {
    return {
      message: "A list of words",
      words: [],
      roomParams: [],

    };
  },
  mounted()
  {
    console.log('sds', this.id);
    console.log('occ', this.occupied);
  },
  computed: {
    style () {
      return {
        background: '#000',
        position: 'absolute',
        width: this.width + 'px',
        height: this.length + 'px',
        top: this.y + 'px',
        left: this.x + 'px',
        transform: 'rotate(' + this.rotation + 'deg)',
        transformOrigin: 'center center'
      }
    },
  },

  methods: {
    onClick: function ()
    {
      this.$emit('click', this.desk);
    }

  }
};
</script>

<style>
.center {
  text-align: center;
}
</style>