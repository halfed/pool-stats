import { expect } from 'chai'
import { shallowMount } from '@vue/test-utils'
import Home from '@/views/Home.vue'

describe('Home.vue', () => {
  it('increments count when button is clicked', () => {
    const wrapper = shallowMount(Home)
    wrapper.find('button').trigger('click')
    //expect(wrapper.find('div').text()).toMatch('1')
    const defaultData = Home.data()
    //expect(defaultData.count).to.equal(0)

    expect(wrapper.find('div').text()).to.equal(1)
  })
})