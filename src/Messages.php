<?php

declare(strict_types=1);

namespace  Mofeier\Messages;

class  Messages
{
    // public  array  $default_return  =  [
    //     'code'  =>  20000,
    //     'message'   =>  'OK',
    // ];
    protected  int  $code;
    protected  string  $message;
    protected  string|array  $data;
    protected  int  $count;
    protected  int  $page;

    // public  function  __construct(?array $result)
    // {
    //     $this->default_return  =   $result;
    // }
    private  function  getStatusCode(array $statusCode=NULL)
    {
        if(is_null($statusCode)){
            return  require_once('StatusCode.php');
        }
        return  $statusCode;
    }
    // 返回消息
    public  function  message(string $message=NULL)
    {
        if(is_null($message)){
            $statusCode  =  $this->getStatusCode();
            if(is_null($this->code)){
                $this->code  =  20000;
            }
            $this->message  =  isset($statusCode[$this->code])? $statusCode[$this->code]:'OK';
            return  $this;
        }
        $this->message  =   $message;
        return  $this;
    }
    private  function  getMessage()
    {
        if(isset($this->message)){
            return  $this->message;
        }
        $this->message();
    }
    // 返回code
    public  function  code(int $code=20000)
    {
        $this->code  =  $code;
        return  $this;
    }
    private  function  getCode()
    {
        if(isset($this->code)){
            return  $this->code;
        }
        $this->code();
    }
    // 数据列表
    public  function  data(string|array  $data, array $other=NULL)
    {
        if($other){
            $data   =   array_merge($data, $other);
        }
        $this->data  =  $data ?? [];
        return  $this;
    }
    // 数据总数量
    public  function  count(int $count=NULL)
    {
        if($count){
            $this->count  =  $count ?? 0;
            return  $this;
        }
    }
    // 当前页码
    public  function  page(int $page=NULL, int $maxPage=NULL)
    {
        if ($page) {
            $this->page  =  $page ?? 0;
            $this->max_page  =  $maxPage??$page;
            return  $this;
        }
    }
    public  function  results()
    {
        $result  =  [
            'code'  =>  $this->getCode(),
            'message'  =>  $this->getMessage(),
        ];

        if(isset($this->data)){
            $result['data'] =   $this->data;
        }
        if(isset($this->count)){
            $result['count'] =   $this->count;
        }
        if(isset($this->page)){
            $result['page'] =   $this->page;
            $result['max_page'] =   $this->max_page;
        }
        return  json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}