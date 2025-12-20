import { AxiosError } from 'axios';
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


export const deleteError = function ( error: any) {
  const { response } = error;

  if (response && response.status == 403) {
    if(!response.data) return;
    const data = response.data as {message:string};
    if(!data) return;
    Swal.fire({
      icon: "error",
      title: `Oops... ${response.status}`,
      text: `${data.message}`,
    });
  } 
};

