<template>
  <div id="app">
    <header>
      <h1>Ecos del Agua : Mapa Interactivo</h1>
    </header>
    <main>
      <div class="responsive-frame">
        <div id="left-column">
          <div id="map" ref="mapContainer"></div>
        </div>
        <div id="right-column">
          <div id="polygon-menu">
            <ul>
              <li v-for="(polygon, index) in polygons" :key="index" @click="showPolygonContent(polygon, index)">
                {{ polygon.name }} 
              </li>
            </ul>
          </div>
          <div id="polygon-content">
            <h2>{{ selectedPolygon.name }}</h2>
            <div v-html="selectedPolygon.content"></div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import mapboxgl from 'mapbox-gl';

export default {
  data() {
    return {
      polygons: [],
      selectedPolygon: {
        name: '',
        content: ''
      },
      hoveredPolygonId: null,
      selectedPolygonId: null,
      map: null // Añadimos la referencia del mapa aquí
    };
  },
  mounted() {
    mapboxgl.accessToken = 'pk.eyJ1IjoicGF1bHRvb2wiLCJhIjoiY2tpbTNveHY5MHB1ODJ4bmFzeG5idzVwNyJ9.Hp_t8btogzDqOMFyOKjWyA';

    this.map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/satellite-v9',
      center: [-99.137539, 19.788065],
      zoom: 13,
      attributionControl: false // Deshabilita el control de atribuciones
    });

    this.$nextTick(() => {
      this.map.resize();
    });

    // Define los límites del área de la laguna
    const minLat = 19.776;
    const maxLat = 19.798;
    const minLng = -99.147;
    const maxLng = -99.127;
    const polygonSize = 0.001; // Tamaño de cada polígono (4 veces más grande)

    const numberOfPolygons = 45; // Número de polígonos a crear

    function generatePolygon(id) {
      const centerLat = Math.random() * (maxLat - minLat) + minLat;
      const centerLng = Math.random() * (maxLng - minLng) + minLng;
      const coordinates = [
        [centerLng - polygonSize / 2, centerLat - polygonSize / 2],
        [centerLng + polygonSize / 2, centerLat - polygonSize / 2],
        [centerLng + polygonSize / 2, centerLat + polygonSize / 2],
        [centerLng - polygonSize / 2, centerLat + polygonSize / 2],
        [centerLng - polygonSize / 2, centerLat - polygonSize / 2]
      ];
      return {
        content:'<iframe width="100%" height="315" src="https://www.youtube.com/embed/sclylFJAA-E" frameborder="0" allowfullscreen></iframe>',
        name: `Historia `+id,
        coordinates: coordinates
      };
    }

    function polygonsOverlap(polygon1, polygon2) {
      const [lng1Min, lat1Min] = polygon1.coordinates[0];
      const [lng1Max, lat1Max] = polygon1.coordinates[2];
      const [lng2Min, lat2Min] = polygon2.coordinates[0];
      const [lng2Max, lat2Max] = polygon2.coordinates[2];

      return (
        lng1Min < lng2Max &&
        lng1Max > lng2Min &&
        lat1Min < lat2Max &&
        lat1Max > lat2Min
      );
    }

    let attempts = 0;
    while (this.polygons.length < numberOfPolygons && attempts < 1000) {
      const newPolygon = generatePolygon(this.polygons.length);
      let overlap = false;

      for (const polygon of this.polygons) {
        if (polygonsOverlap(newPolygon, polygon)) {
          overlap = true;
          break;
        }
      }

      if (!overlap) {
        this.polygons.push(newPolygon);
      }

      attempts++;
    }

    console.log(`Generated ${this.polygons.length} polygons with ${attempts} attempts`);

    // Agrega los polígonos al mapa
    this.map.on('load', () => {
      this.polygons.forEach((polygon, index) => {
        const polygonId = `${polygon.name} ${index + 1}`;

        const polygonFeature = {
          type: 'Feature',
          geometry: {
            type: 'Polygon',
            coordinates: [polygon.coordinates]
          },
          properties: {
            name: polygonId,
            content: `${polygon.content} ${index + 1}`
          }
        };

        this.map.addLayer({
          id: polygonId,
          type: 'fill',
          source: {
            type: 'geojson',
            data: {
              type: 'FeatureCollection',
              features: [polygonFeature]
            }
          },
          layout: {},
          paint: {
            'fill-color': '#088',
            'fill-opacity': [
              'case',
              ['==', ['get', 'name'], this.hoveredPolygonId], 0.7,
              ['==', ['get', 'name'], this.selectedPolygonId], 0.9,
              0.5
            ]
          }
        });

        // Cambiar el color del polígono al pasar el mouse por encima
        this.map.on('mouseenter', polygonId, () => {
          this.hoveredPolygonId = polygonId;
          this.updatePolygonOpacity();
        });

        this.map.on('mouseleave', polygonId, () => {
          this.hoveredPolygonId = null;
          this.updatePolygonOpacity();
        });

        // Mostrar contenido del polígono al hacer clic en él
        this.map.on('click', polygonId, () => {
          this.showPolygonContent(polygon, index);
        });
      });
    });
  },
  methods: {
    showPolygonContent(polygon, index) {
      this.selectedPolygon = polygon;
      this.selectedPolygonId = `${polygon.name} ${index + 1}`;
      this.hoveredPolygonId = null;
      this.updatePolygonOpacity();
    },
    updatePolygonOpacity() {
      this.polygons.forEach((polygon, index) => {
        const polygonId = `${polygon.name} ${index + 1}`;
        this.map.setPaintProperty(polygonId, 'fill-opacity', polygonId === this.selectedPolygonId ? 0.9 : (polygonId === this.hoveredPolygonId ? 0.7 : 0.5));
      });
    }
  }
};
</script>

<style>
#app {
  display: flex;
  flex-direction: column;
  height: 100vh;
}

header {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 10px;
}

main {
  display: flex;
  flex: 1;
  overflow: hidden;
}

.responsive-frame {
  display: flex;
  flex: 1;
  flex-direction: row;
  max-width: 100%;
  max-height: 100%;
  overflow: hidden;
}

#left-column, #right-column {
  display: flex;
  flex: 1;
  flex-direction: column;
  overflow: hidden;
}

#map {
  width: 100%;
  height: 100%;
}

#polygon-menu {
  height: 25%;
  overflow-y: auto;
  background-color: #f0f0f0;
  padding: 10px;
}

#polygon-menu ul {
  list-style-type: none;
  padding: 0;
}

#polygon-menu li {
  cursor: pointer;
  padding: 5px;
  border-bottom: 1px solid #ccc;
}

#polygon-menu li:hover {
  background-color: #ddd;
}

#polygon-content {
  height: 25%;
  padding: 20px;
}
</style>
