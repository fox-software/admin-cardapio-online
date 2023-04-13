
function toast(title = "", message = "", type = "", position = "topRight") {
  switch (type) {
    case "info":
      iziToast.info({ title, message, position });
      break;
    case "error":
      iziToast.error({ title, message, position });
      break;
    case "warning":
      iziToast.warning({ title, message, position });
      break;
    case "success":
      iziToast.success({ title, message, position });
      break;
    default:
      iziToast.show({ position, title, message });
      break;
  }
}
