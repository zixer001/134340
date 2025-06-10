module.exports.serviceError = class ServiceError extends Error {

    constructor (error) {
      super()
      this.message = 'Service Error'
      this.status = error?.status || 400
      this.statusCode = error?.statusCode || 4000
      this.statusText = error?.statusText
      this.description = error?.description || null
    }
  }

  module.exports.handleError =  handleError = (error) => {
    
    if (error.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx
        // console.log(error.response.data);
        // console.log(error.response.status);
        // console.log(error.response.headers);
        return {
            status: error.response.status,
            statusCode: 4000,
            statusText: error.message,
            description: error.response.data
        };
      } else {
        // Something happened in setting up the request that triggered an Error
        return {
            status: error.status || 400,
            statusCode: error.statusCode || 4000,
            statusText: error.statusText,
            description: error.description
        };
      }
      
  }