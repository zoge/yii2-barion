<?php
namespace zoge\barion\common;

abstract class PaymentStatus
{
    // 10
    const Prepared = "Prepared";
    // 20
    const Started = "Started";
    // 30
    const Reserved = "Reserved";
    // 40
    const Canceled = "Canceled";
    // 50
    const Succeeded = "Succeeded";
    // 60
    const Failed = "Failed";
}