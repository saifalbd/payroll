import Swal from 'sweetalert2';


export const deleteConfirm = async function (
  this: any,
  text: string
) {
  const is = await Swal.fire({
    title: "Are you sure? Delete",
    text: text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  });
  if (is.isConfirmed) {
    return Promise.resolve(true);
  } else {
    return Promise.resolve(false);
  }
};