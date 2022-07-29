var uppy = new Uppy.Core({
  id: 'uppy',
  autoProceed: false,
  allowMultipleUploadBatches: false,
  debug: false,
  restrictions: {
    maxFileSize: null,
    minFileSize: null,
    maxTotalFileSize: null,
    maxNumberOfFiles: 1,
    minNumberOfFiles: 1,
    allowedFileTypes: ['.jpg', '.jpeg', '.png'],
    requiredMetaFields: [],
  },
  meta: {},
  onBeforeFileAdded: (currentFile, files) => currentFile,
  onBeforeUpload: (files) => {},
  locale: {},
  store: new Uppy.DefaultStore(),
  logger: Uppy.debugLogger,
  infoTimeout: 5000,
})

uppy.use(Uppy.Tus, { endpoint: 'https://tusd.tusdemo.net/files/' })
uppy.use(Uppy.Dashboard, {
  id: 'Dashboard',
  target: '#drag-drop-area',
  metaFields: [],
  trigger: null,
  inline: true,
  width: 750,
  height: 150,
  thumbnailWidth: 150,
  showLinkToFileUploadResult: false,
  showProgressDetails: true,
  hideUploadButton: false,
  hideRetryButton: false,
  hidePauseResumeButton: false,
  hideCancelButton: false,
  hideProgressAfterFinish: false,
  doneButtonHandler: () => {
    this.uppy.reset()
    this.requestCloseModal()
  },
  note: null,
  closeModalOnClickOutside: false,
  closeAfterFinish: false,
  disableStatusBar: false,
  disableInformer: false,
  disableThumbnailGenerator: false,
  disablePageScrollWhenModalOpen: true,
  animateOpenClose: true,
  fileManagerSelectionType: 'files',
  proudlyDisplayPoweredByUppy: true,
  onRequestCloseModal: () => this.closeModal(),
  showSelectedFiles: true,
  showRemoveButtonAfterComplete: false,
  browserBackButtonClose: false,
  theme: 'light',
  autoOpenFileEditor: false,
  disableLocalFiles: false,
})