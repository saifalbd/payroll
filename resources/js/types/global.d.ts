import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js';
import { PageProps as AppPageProps, User } from './';

declare global {
  interface Window {
    axios: AxiosInstance;
  }


  interface Auth {
    companyName: string
    name: string
    id: number
    avatar: string
    email: string
    phone: any
    designation: string
    department: string
    has: string
  }

  interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    avatar_id: number
    company_id: number
    company: Company
    thumbnail: Thumbnail
  }


  interface Company {
    id: number
    title: string
    sortTitle: string
    sort_title: string
    email: string
    phone: any
    currency: Currency
    website: any
    startAt: string
    isExpire: boolean
    expireAt: string
    partner_id: number
    partner: Partner
    isTrial: boolean
    isVerified: boolean
    published: boolean
    isDelete: boolean
    vouchers_count: number
    fee: number
    lastVoucherDate: string | null
    created_at: string
    packageName: string
    number_of_branch: number
    branches_count: string
    is_called: boolean
    thumbnail: Thumbnail
    called: {
      id: string,
      company_id: 387,
      is_call: 1,
      summary: string
    } | null
  }


  export interface Employee {
    id: number
    company_id: number
    employee_id: number
    employee_name: string
    designation: string
    department_id: number
    joining_date: string
    contact_no: string
    email: string
    linkedin: string
    nid: string
    current_address: string
    permanent_address: string
    district: string
    police_station: string
    post_office: string
    village: string
    father: string
    mother: string
    avatar_id: number
    created_at: string
    updated_at: string
    company: Company
    department: {
      id: number
      name: string
    }
    avatar: Thumbnail
    salary_setup:SalarySetup
  }


  interface Bill {
    id: number
    company_id: number
    invoice_id: number
    amount: number
    remark: string
    status: string
    trx_id: any
    trx_date: string
    payment_id: any
    alert_from: string
    over_due_date: string
    created_at: string
    updated_at: string
    url: string
    company: Company
    items: Array<
      {
        id: number
        bill_id: number
        month: string
        fee: number
        number_of_branch: number
        bill: number
        remark: string

      }
    >
  }

  interface Currency {
    id: number
    name: string
    code: string
    symbol: string
  }

  interface Partner {
    id: number
    name: string
    address: string
    mobile: string
    email: string
    web: string
    contact_person: string
    image_id: number
    is_default: number
    created_at: string
    updated_at: string
  }

  export interface Review {
    id: number
    user_id: number
    content: string
    publish: boolean
    created_at: string
    updated_at: string
    user: User
  }



  export interface Thumbnail {
    id: number
    company_id: any
    name: string
    file_name: string
    extension: string
    disk: string
    is_active: number
    path: string
    image_for: string
    created_at: string
    updated_at: string
    done: number
    url: string
  }


  export interface Ledger {
    id: number
    title: string

  }
  export interface Department {
    id: number
    name: string

  }


  export interface ScaleItem {
    scale_id: number
    payhead_id: number
    payhead:PayHead
    parcent_of:PayHead
    calc_type: string
    value: number
    parcent_of_id: number
    formula: '+' | '-' | '/' | '*'
    basis: `${string}%`

  }

  export interface SalaryScale {
    id: number
    title: string
    created_at: string
    updated_at: string
    items:ScaleItem[]
  }
  export interface PayHead {

    id: number
    title: string
    type: 'earning'|'dedcution'
    ledger: Ledger
    created_at: string
    updated_at: string

  }



  var route: typeof ziggyRoute;
  var Ziggy: ZiggyConfig;
  var lottie: any;
  var axios: AxiosInstance
}

declare module 'vue' {
  interface ComponentCustomProperties {
    route: typeof ziggyRoute;
  }
}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaPageProps, AppPageProps { }
}
