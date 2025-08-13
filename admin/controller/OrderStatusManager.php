<?php
class OrderStatusManager {
    
    // Định nghĩa các trạng thái và luồng chuyển đổi hợp lệ
    const STATUS_PENDING = 'Chờ xác nhận';
    const STATUS_CONFIRMED = 'Đã xác nhận'; 
    const STATUS_SHIPPING = 'Đang giao';
    const STATUS_DELIVERED = 'Đã giao';
    const STATUS_CANCELLED = 'Đã hủy';
    
    // Luồng chuyển đổi trạng thái hợp lệ
    private static $validTransitions = [
        self::STATUS_PENDING => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED],
        self::STATUS_CONFIRMED => [self::STATUS_SHIPPING, self::STATUS_CANCELLED],
        self::STATUS_SHIPPING => [self::STATUS_DELIVERED], // KHÔNG thể hủy khi đang giao
        self::STATUS_DELIVERED => [], // Không thể chuyển từ đã giao
        self::STATUS_CANCELLED => []  // KHÔNG thể chuyển từ đã hủy
    ];
    
    // Màu sắc cho từng trạng thái
    private static $statusColors = [
        self::STATUS_PENDING => 'warning',    // Vàng
        self::STATUS_CONFIRMED => 'info',     // Xanh dương
        self::STATUS_SHIPPING => 'primary',   // Xanh đậm
        self::STATUS_DELIVERED => 'success',  // Xanh lá
        self::STATUS_CANCELLED => 'danger'    // Đỏ
    ];
    
    // Mô tả trạng thái
    private static $statusDescriptions = [
        self::STATUS_PENDING => 'Đơn hàng đang chờ được xác nhận',
        self::STATUS_CONFIRMED => 'Đơn hàng đã được xác nhận và đang chuẩn bị',
        self::STATUS_SHIPPING => 'Đơn hàng đang được giao đến khách hàng',
        self::STATUS_DELIVERED => 'Đơn hàng đã được giao thành công',
        self::STATUS_CANCELLED => 'Đơn hàng đã bị hủy'
    ];
    
    /**
     * Kiểm tra xem có thể chuyển từ trạng thái cũ sang trạng thái mới không
     */
    public static function canTransition($fromStatus, $toStatus) {
        if (!isset(self::$validTransitions[$fromStatus])) {
            return false;
        }
        
        return in_array($toStatus, self::$validTransitions[$fromStatus]);
    }
    
    /**
     * Lấy danh sách trạng thái có thể chuyển đến từ trạng thái hiện tại
     */
    public static function getValidNextStatuses($currentStatus) {
        return self::$validTransitions[$currentStatus] ?? [];
    }
    
    /**
     * Lấy tất cả trạng thái
     */
    public static function getAllStatuses() {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_SHIPPING,
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ];
    }
    
    /**
     * Lấy màu CSS cho trạng thái
     */
    public static function getStatusColor($status) {
        return self::$statusColors[$status] ?? 'secondary';
    }
    
    /**
     * Lấy mô tả trạng thái
     */
    public static function getStatusDescription($status) {
        return self::$statusDescriptions[$status] ?? '';
    }
    
    /**
     * Lấy CSS class cho status badge
     */
    public static function getStatusClass($status) {
        $classMap = [
            self::STATUS_PENDING => 'cho-xac-nhan',
            self::STATUS_CONFIRMED => 'da-xac-nhan',
            self::STATUS_SHIPPING => 'dang-giao',
            self::STATUS_DELIVERED => 'da-giao',
            self::STATUS_CANCELLED => 'da-huy'
        ];
        return $classMap[$status] ?? 'unknown';
    }
    
    /**
     * Kiểm tra xem trạng thái có cần xử lý tồn kho không
     */
    public static function needsInventoryUpdate($fromStatus, $toStatus) {
        // Cần trừ tồn kho khi chuyển từ "Chờ xác nhận" -> "Đã xác nhận"
        if ($fromStatus === self::STATUS_PENDING && $toStatus === self::STATUS_CONFIRMED) {
            return 'decrease';
        }
        
        // Cần hoàn trả tồn kho khi hủy đơn đã xác nhận
        if (in_array($fromStatus, [self::STATUS_CONFIRMED, self::STATUS_SHIPPING]) && $toStatus === self::STATUS_CANCELLED) {
            return 'increase';
        }
        
        return false;
    }
    
    /**
     * Validate trạng thái có hợp lệ không
     */
    public static function isValidStatus($status) {
        return in_array($status, self::getAllStatuses());
    }
    
    /**
     * Kiểm tra xem đơn hàng có thể hủy không
     */
    public static function canCancel($currentStatus) {
        return self::canTransition($currentStatus, self::STATUS_CANCELLED);
    }
    
    /**
     * Kiểm tra xem đơn hàng có thể chỉnh sửa không (đã hoàn thành thì không sửa được)
     */
    public static function canEdit($currentStatus) {
        return !in_array($currentStatus, [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }
    
    /**
     * Kiểm tra xem đơn hàng đã hoàn thành chưa (giao hoặc hủy)
     */
    public static function isCompleted($currentStatus) {
        return in_array($currentStatus, [self::STATUS_DELIVERED, self::STATUS_CANCELLED]);
    }
    
    /**
     * Lấy thông báo khi chuyển đổi trạng thái
     */
    public static function getTransitionMessage($fromStatus, $toStatus) {
        $messages = [
            self::STATUS_PENDING . '_' . self::STATUS_CONFIRMED => 'Đơn hàng đã được xác nhận và sẽ được chuẩn bị.',
            self::STATUS_CONFIRMED . '_' . self::STATUS_SHIPPING => 'Đơn hàng đang được giao đến khách hàng.',
            self::STATUS_SHIPPING . '_' . self::STATUS_DELIVERED => 'Đơn hàng đã được giao thành công.',
            '_' . self::STATUS_CANCELLED => 'Đơn hàng đã được hủy.'
        ];
        
        $key = $fromStatus . '_' . $toStatus;
        $generalKey = '_' . $toStatus;
        
        return $messages[$key] ?? $messages[$generalKey] ?? "Trạng thái đơn hàng đã được cập nhật thành: $toStatus";
    }
    
    /**
     * Lấy lý do hạn chế chuyển đổi trạng thái
     */
    public static function getTransitionRestrictionReason($fromStatus, $toStatus) {
        if ($fromStatus === self::STATUS_SHIPPING && $toStatus === self::STATUS_CANCELLED) {
            return "Không thể hủy đơn hàng khi đang giao.";
        }
        
        if ($fromStatus === self::STATUS_CANCELLED) {
            return "Không thể thay đổi trạng thái đơn hàng đã hủy.";
        }
        
        if ($fromStatus === self::STATUS_DELIVERED) {
            return "Không thể thay đổi trạng thái đơn hàng đã giao.";
        }
        
        return "Không thể chuyển từ '{$fromStatus}' sang '{$toStatus}'.";
    }
}
?>
