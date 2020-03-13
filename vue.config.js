module.exports = {
  lintOnSave: false,
  devServer: {
    proxy: 'http://localhost/vue-projects/pool-stats/'
  },
  pages: {
    index: {
      entry: 'src/main.js',
      template: 'public/index.php'
    },
  },
}
