document.querySelector('.Uppy').innerHTML = ''

const uppy = new Uppy.Core({
  id: 'uppy',
  autoProceed: false,
  allowMultipleUploadBatches: false,
  debug: true,
  restrictions: {
    maxFileSize: 4096000,
    minFileSize: null,
    maxTotalFileSize: null,
    maxNumberOfFiles: 1,
    minNumberOfFiles: 1,
    allowedFileTypes: ['.jpg', '.jpeg', '.png'],
    requiredMetaFields: [],
  },
  infoTimeout: 5000,
})

uppy.use(Uppy.Dashboard, {
  id: 'Dashboard',
  target: '.Uppy',
  //metaFields: [],
  trigger: null,
  inline: true,
  // width: 750,
  // height: 200,
  // thumbnailWidth: 200,
  showLinkToFileUploadResult: false,
  note: null,
  proudlyDisplayPoweredByUppy: false,
  autoOpenFileEditor: true,
  disableLocalFiles: false,
})

uppy.use(Uppy.Compressor, {
  maxHeight: 500,
  minWidth: 500,
  quality: 0.8
})

uppy.use(Uppy.ImageEditor, {
  target: Uppy.Dashboard,
  quality: 0.8,
  cropperOptions: {
    viewMode: 1,
    background: false,
    autoCropArea: 1,
    responsive: true,
    croppedCanvasOptions: {},
    aspectRatio: 1 / 1,
  },
  actions: {
    revert: false,
    rotate: false,
    granularRotate: false,
    flip: true,
    zoomIn: true,
    zoomOut: true,
    cropSquare: false,
    cropWidescreen: false,
    cropWidescreenVertical: false,
  },
})

uppy.use(Uppy.XHRUpload, {
  endpoint: '/leif/update-profile-picture',
  formData: true,
  fieldName: 'files[]',
})

uppy.on('upload-success', (file, response) => {
  window.location.replace("profile");
})