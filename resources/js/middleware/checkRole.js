export default (to, from, next) => {
  
  const user_role = JSON.parse(localStorage.getItem('RlUsFcekR')); 
 
  if (!user_role) {
      next({ name: 'home' })

      return false;
  }
}